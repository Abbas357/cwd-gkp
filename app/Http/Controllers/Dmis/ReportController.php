<?php

namespace App\Http\Controllers\dmis;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Damage;
use App\Models\Office;
use App\Models\District;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReportController extends Controller
{
    use AuthorizesRequests;
    
    public function index(Request $request)
    {
        return view('modules.dmis.reports.index');
    }

    public function loadReport(Request $request) {
        set_time_limit(300);
        ini_set('max_execution_time', 300);
        $report_type = $request->get('report_type') ?? 'Summary';
        $type = $request->get('type') ?? 'Road';
        $userId = $request->get('user_id') ?? 4;
        $reportDate = $request->get('report_date') ?? now()->format('Y-m-d');

        return match ($report_type) {
            'Summary'         => $this->summary($type, $userId),
            'Daily Situation' => $this->dailySituation($type, $reportDate, $userId),
            'District Wise'   => $this->districtWise($type),
            default           => $this->summary($type, $userId),
        };
    }
    
    public function summary($type, $userId)
    {
        $this->authorize('viewMainReport', \App\Models\Damage::class);

        if (in_array(request()->user()->currentOffice->type, ['Regional', 'Divisional'])) {
            $selectedUser = request()->user();
        } elseif(request()->user()->currentOffice->type == 'District') {
            $selectedUser = request()->user()->getDirectSupervisor();
        } else {
            $selectedUser = User::findOrFail($userId);
        }
        
        $duration = request()->get('duration');
        $startDate = request()->get('start_date');
        $endDate = request()->get('end_date');
        $dateType = request()->get('date_type', 'report_date');
        
        // Initialize date variables as null
        $parsedStartDate = null;
        $parsedEndDate = null;
        
        // Only process dates if duration is provided
        if (!empty($duration)) {
            if ($duration !== 'Custom') {
                $parsedEndDate = now()->startOfDay();
                $parsedStartDate = now()->subDays((int)$duration)->startOfDay();
            } else {
                // Custom duration - use provided dates or defaults
                $parsedStartDate = $startDate ? Carbon::parse($startDate)->startOfDay() : now()->subDays(30)->startOfDay();
                $parsedEndDate = $endDate ? Carbon::parse($endDate)->endOfDay() : now()->endOfDay();
            }
        }
        // If no duration is provided, dates remain null and no date filtering will be applied

        $officerDistricts = request()->user()->districts();

        if ($officerDistricts->isEmpty()) {
            return view('modules.dmis.reports.main', [
                'subordinatesWithDistricts' => collect(),
                'total' => [
                    'totalDamagedInfrastructureCount' => 0,
                    'totalDamageCount' => 0,
                    'totalDamagedInfrastructureSum' => 0,
                    'totalDamagedInfrastructureTotalCount' => 0,
                    'totalFullyRestored' => 0,
                    'totalPartiallyRestored' => 0,
                    'totalNotRestored' => 0,
                    'totalRestorationCost' => 0,
                    'totalRehabilitationCost' => 0,
                ],
                'subordinateDesignation' => 'Officer',
                'selectedUser' => $selectedUser,
                'startDate' => $parsedStartDate,
                'endDate' => $parsedEndDate
            ]);
        }

        // Handle "All" type by generating reports for each infrastructure type
        if ($type === 'All') {
            $infrastructureTypes = setting('infrastructure_type', 'dmis', ['Road', 'Bridge', 'Culvert']);
            $allReportsHtml = '';
            
            foreach ($infrastructureTypes as $infraType) {
                $reportData = $this->generateReportForType($infraType, $selectedUser, $parsedStartDate, $parsedEndDate, $officerDistricts, $dateType);
                
                if ($reportData['subordinatesWithDistricts']->isNotEmpty()) {
                    $html = view('modules.dmis.reports.partials.summary', [
                        'subordinatesWithDistricts' => $reportData['subordinatesWithDistricts'],
                        'total' => $reportData['total'],
                        'subordinateDesignation' => $reportData['subordinateDesignation'],
                        'selectedUser' => $selectedUser,
                        'type' => $infraType,
                        'startDate' => $parsedStartDate,
                        'endDate' => $parsedEndDate
                    ])->render();
                    
                    $allReportsHtml .= $html . '<br><hr />';
                }
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'result' => $allReportsHtml ?: '<div class="alert alert-info text-center"><i class="bi-info-circle me-2"></i>No damages found for any infrastructure type.</div>',
                ],
            ]);
        }

        // Original logic for single infrastructure type
        $reportData = $this->generateReportForType($type, $selectedUser, $parsedStartDate, $parsedEndDate, $officerDistricts, $dateType);

        $html = view('modules.dmis.reports.partials.summary', [
            'subordinatesWithDistricts' => $reportData['subordinatesWithDistricts'],
            'total' => $reportData['total'],
            'subordinateDesignation' => $reportData['subordinateDesignation'],
            'selectedUser' => $selectedUser,
            'type' => $type,
            'startDate' => $parsedStartDate,
            'endDate' => $parsedEndDate
        ])->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    private function generateReportForType($type, $selectedUser, $startDate, $endDate, $officerDistricts, $dateType)
    {
        $directSubordinates = $selectedUser->getDirectSubordinates();

        $totalDamagedInfrastructureCount = 0;
        $totalDamageCount = 0;
        $totalDamagedInfrastructureSum = 0;
        $totalDamagedInfrastructureTotalCount = 0;
        $totalFullyRestored = 0;
        $totalPartiallyRestored = 0;
        $totalNotRestored = 0;
        $totalRestorationCost = 0;
        $totalRehabilitationCost = 0;

        $subordinatesWithDistricts = collect();

        foreach ($directSubordinates as $subordinate) {
            $subordinatePostingId = $subordinate->currentPosting?->id;

            if (!$subordinatePostingId) {
                continue;
            }

            $subordinateDistricts = $subordinate->districts()->intersect($officerDistricts);

            if ($subordinateDistricts->isEmpty()) {
                continue;
            }

            $districts = collect();

            foreach ($subordinateDistricts as $district) {
                $infraIds = $district->infrastructures
                    ->where('type', $type)
                    ->pluck('id')
                    ->toArray();

                if (empty($infraIds)) {
                    continue;
                }

                $subordinateTeam = $subordinate->getSubordinates();
                $teamPostingIds = $subordinateTeam->pluck('currentPosting.id')->filter()->toArray();
                $teamPostingIds[] = $subordinatePostingId;
                
                $damageQuery = Damage::whereIn('infrastructure_id', $infraIds)
                    ->whereIn('posting_id', $teamPostingIds);

                if ($startDate && $endDate) {
                    $damageQuery->whereBetween($dateType, [$startDate, $endDate]);
                }

                $district->damaged_infrastructure_count = $damageQuery->clone()->distinct('infrastructure_id')
                    ->count('infrastructure_id');

                if ($district->damaged_infrastructure_count == 0) {
                    continue;
                }

                $damagedInfraIds = $damageQuery->clone()->pluck('infrastructure_id')->unique()->toArray();
                $district->damaged_infrastructure_total_count = $district->infrastructures
                    ->where('type', $type)
                    ->whereIn('id', $damagedInfraIds)
                    ->sum('length');

                $district->damaged_infrastructure_sum = $damageQuery->clone()->sum('damaged_length');
                $district->damage_count = $damageQuery->clone()->count();
                $district->fully_restored = $damageQuery->clone()->where('road_status', 'Fully restored')->count();
                $district->partially_restored = $damageQuery->clone()->where('road_status', 'Partially restored')->count();
                $district->not_restored = $damageQuery->clone()->where('road_status', 'Not restored')->count();
                $district->restoration = $damageQuery->clone()->sum('approximate_restoration_cost');
                $district->rehabilitation = $damageQuery->clone()->sum('approximate_rehabilitation_cost');

                $districts->push($district);

                $totalDamagedInfrastructureCount += $district->damaged_infrastructure_count;
                $totalDamageCount += $district->damage_count;
                $totalDamagedInfrastructureSum += $district->damaged_infrastructure_sum;
                $totalDamagedInfrastructureTotalCount += $district->damaged_infrastructure_total_count;
                $totalFullyRestored += $district->fully_restored;
                $totalPartiallyRestored += $district->partially_restored;
                $totalNotRestored += $district->not_restored;
                $totalRestorationCost += $district->restoration;
                $totalRehabilitationCost += $district->rehabilitation;
            }

            if ($districts->isNotEmpty()) {
                $subordinatesWithDistricts->push([
                    'subordinate' => $subordinate,
                    'districts' => $districts,
                    'district_count' => $districts->count()
                ]);
            }
        }

        $total = [
            'totalDamagedInfrastructureCount' => $totalDamagedInfrastructureCount,
            'totalDamageCount' => $totalDamageCount,
            'totalDamagedInfrastructureSum' => $totalDamagedInfrastructureSum,
            'totalDamagedInfrastructureTotalCount' => $totalDamagedInfrastructureTotalCount,
            'totalFullyRestored' => $totalFullyRestored,
            'totalPartiallyRestored' => $totalPartiallyRestored,
            'totalNotRestored' => $totalNotRestored,
            'totalRestorationCost' => $totalRestorationCost,
            'totalRehabilitationCost' => $totalRehabilitationCost,
        ];

        $subordinateDesignation = "Officer";
        if ($directSubordinates->isNotEmpty() && $directSubordinates->first()->currentDesignation) {
            $subordinateDesignation = $directSubordinates->first()->currentDesignation->name;
        }

        return [
            'subordinatesWithDistricts' => $subordinatesWithDistricts,
            'total' => $total,
            'subordinateDesignation' => $subordinateDesignation
        ];
    }

    public function dailySituation($type, $reportDate, $userId)
    {
        $this->authorize('viewSituationReport', \App\Models\Damage::class);

        if (in_array(request()->user()->currentOffice->type, ['Regional', 'Divisional'])) {
            $selectedUser = request()->user();
        } elseif(request()->user()->currentOffice->type == 'District') {
            $selectedUser = request()->user()->getDirectSupervisor();
        } else {
            $selectedUser = User::findOrFail($userId);
        }

        $officerDistricts = $selectedUser->districts();
        $dateType = request()->get('date_type', 'report_date');

        if ($officerDistricts->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'result' => '<div class="alert alert-info text-center"><i class="bi-info-circle me-2"></i>No districts assigned to this officer.</div>',
                ],
            ]);
        }

        // Handle "All" type by generating reports for each infrastructure type
        if ($type === 'All') {
            $infrastructureTypes = setting('infrastructure_type', 'dmis', ['Road', 'Bridge', 'Culvert']);
            $allReportsHtml = '';
            
            foreach ($infrastructureTypes as $infraType) {
                $reportData = $this->generateDailySituationForType($infraType, $reportDate, $selectedUser, $officerDistricts, $dateType);
                
                if ($reportData['subordinatesWithDistricts']->isNotEmpty()) {
                    $html = view('modules.dmis.reports.partials.daily-situation', [
                        'subordinatesWithDistricts' => $reportData['subordinatesWithDistricts'],
                        'total' => $reportData['total'],
                        'subordinateDesignation' => $reportData['subordinateDesignation'],
                        'selectedUser' => $selectedUser,
                        'reportDate' => $reportDate,
                        'type' => $infraType
                    ])->render();
                    
                    $allReportsHtml .= $html . '<br><hr />';
                }
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'result' => $allReportsHtml ?: '<div class="alert alert-info text-center"><i class="bi-info-circle me-2"></i>No damages found for any infrastructure type on this date.</div>',
                ],
            ]);
        }

        // Original logic for single infrastructure type
        $reportData = $this->generateDailySituationForType($type, $reportDate, $selectedUser, $officerDistricts, $dateType);

        $html = view('modules.dmis.reports.partials.daily-situation', [
            'subordinatesWithDistricts' => $reportData['subordinatesWithDistricts'],
            'total' => $reportData['total'],
            'subordinateDesignation' => $reportData['subordinateDesignation'],
            'selectedUser' => $selectedUser,
            'reportDate' => $reportDate,
            'type' => $type
        ])->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    private function generateDailySituationForType($type, $reportDate, $selectedUser, $officerDistricts, $dateType)
    {
        $directSubordinates = $selectedUser->getDirectSubordinates();

        $totalDamagedInfrastructureCount = 0;
        $totalDamageCount = 0;
        $totalDamagedInfrastructureSum = 0;
        $totalDamagedInfrastructureTotalCount = 0;
        $totalFullyRestored = 0;
        $totalPartiallyRestored = 0;
        $totalNotRestored = 0;
        $totalRestorationCost = 0;
        $totalRehabilitationCost = 0;
        $subordinatesWithDistricts = collect();

        foreach ($directSubordinates as $subordinate) {
            $subordinatePostingId = $subordinate->currentPosting?->id;

            if (!$subordinatePostingId) {
                continue;
            }

            // Only get districts that are both under the subordinate AND under the selected officer
            $subordinateDistricts = $subordinate->districts()->intersect($officerDistricts);

            if ($subordinateDistricts->isEmpty()) {
                continue;
            }

            $districts = collect();

            foreach ($subordinateDistricts as $district) {
                $infraIds = $district->infrastructures
                    ->where('type', $type)
                    ->pluck('id')
                    ->toArray();

                if (empty($infraIds)) {
                    continue;
                }

                $subordinateTeam = $subordinate->getSubordinates();
                $teamPostingIds = $subordinateTeam->pluck('currentPosting.id')->filter()->toArray();
                $teamPostingIds[] = $subordinatePostingId;

                // Filter damages for the specific date (daily report)
                $damageQuery = Damage::whereIn('infrastructure_id', $infraIds)
                    ->whereIn('posting_id', $teamPostingIds)
                    ->whereDate($dateType, $reportDate); // Filter by date

                $district->damaged_infrastructure_count = $damageQuery->clone()->distinct('infrastructure_id')
                    ->count('infrastructure_id');

                if ($district->damaged_infrastructure_count == 0) {
                    continue;
                }

                $damagedInfraIds = $damageQuery->clone()->pluck('infrastructure_id')->unique()->toArray();
                $district->damaged_infrastructure_total_count = $district->infrastructures
                    ->where('type', $type)
                    ->whereIn('id', $damagedInfraIds)
                    ->sum('length');

                $district->damaged_infrastructure_sum = $damageQuery->clone()->sum('damaged_length');
                $district->damage_count = $damageQuery->clone()->count();
                $district->fully_restored = $damageQuery->clone()->where('road_status', 'Fully restored')->count();
                $district->partially_restored = $damageQuery->clone()->where('road_status', 'Partially restored')->count();
                $district->not_restored = $damageQuery->clone()->where('road_status', 'Not restored')->count();
                $district->restoration = $damageQuery->clone()->sum('approximate_restoration_cost');
                $district->rehabilitation = $damageQuery->clone()->sum('approximate_rehabilitation_cost');

                // Additional daily metrics
                $district->new_damages_today = $damageQuery->clone()->count();
                $district->updated_damages_today = Damage::whereIn('infrastructure_id', $infraIds)
                    ->whereIn('posting_id', $teamPostingIds)
                    ->whereDate('updated_at', $reportDate)
                    ->where('created_at', '<', $reportDate)
                    ->count();

                $districts->push($district);

                $totalDamagedInfrastructureCount += $district->damaged_infrastructure_count;
                $totalDamageCount += $district->damage_count;
                $totalDamagedInfrastructureSum += $district->damaged_infrastructure_sum;
                $totalDamagedInfrastructureTotalCount += $district->damaged_infrastructure_total_count;
                $totalFullyRestored += $district->fully_restored;
                $totalPartiallyRestored += $district->partially_restored;
                $totalNotRestored += $district->not_restored;
                $totalRestorationCost += $district->restoration;
                $totalRehabilitationCost += $district->rehabilitation;
            }

            if ($districts->isNotEmpty()) {
                $subordinatesWithDistricts->push([
                    'subordinate' => $subordinate,
                    'districts' => $districts,
                    'district_count' => $districts->count()
                ]);
            }
        }

        $total = [
            'totalDamagedInfrastructureCount' => $totalDamagedInfrastructureCount,
            'totalDamageCount' => $totalDamageCount,
            'totalDamagedInfrastructureSum' => $totalDamagedInfrastructureSum,
            'totalDamagedInfrastructureTotalCount' => $totalDamagedInfrastructureTotalCount,
            'totalFullyRestored' => $totalFullyRestored,
            'totalPartiallyRestored' => $totalPartiallyRestored,
            'totalNotRestored' => $totalNotRestored,
            'totalRestorationCost' => $totalRestorationCost,
            'totalRehabilitationCost' => $totalRehabilitationCost,
        ];

        $subordinateDesignation = "Officer";
        if ($directSubordinates->isNotEmpty() && $directSubordinates->first()->currentDesignation) {
            $subordinateDesignation = $directSubordinates->first()->currentDesignation->name;
        }

        return [
            'subordinatesWithDistricts' => $subordinatesWithDistricts,
            'total' => $total,
            'subordinateDesignation' => $subordinateDesignation
        ];
    }

    public function districtWise($type)
    {
        $this->authorize('viewDistrictWiseReport', \App\Models\Damage::class);

        $duration = request()->get('duration');
        $startDate = request()->get('start_date');
        $endDate = request()->get('end_date');
        $dateType = request()->get('date_type', 'report_date');
        
        // Initialize date variables as null
        $parsedStartDate = null;
        $parsedEndDate = null;
        
        // Only process dates if duration is provided
        if (!empty($duration)) {
            if ($duration !== 'Custom') {
                $parsedEndDate = now()->endOfDay();
                $parsedStartDate = now()->subDays((int)$duration)->startOfDay();
            } else {
                // Custom duration - use provided dates or defaults
                $parsedStartDate = $startDate ? Carbon::parse($startDate)->startOfDay() : now()->subDays(30)->startOfDay();
                $parsedEndDate = $endDate ? Carbon::parse($endDate)->endOfDay() : now()->endOfDay();
            }
        }
        // If no duration is provided, dates remain null and no date filtering will be applied

        $districts = request()->user()->districts();

        // Handle "All" type by generating reports for each infrastructure type
        if ($type === 'All') {
            $infrastructureTypes = setting('infrastructure_type', 'dmis', ['Road', 'Bridge', 'Culvert']);
            $allReportsHtml = '';
            
            foreach ($infrastructureTypes as $infraType) {
                $reportData = $this->generateDistrictWiseForType($infraType, $parsedStartDate, $parsedEndDate, $districts, $dateType);
                
                if ($reportData['districtStats']->isNotEmpty()) {
                    $html = view('modules.dmis.reports.partials.district-wise', [
                        'districtStats' => $reportData['districtStats'],
                        'total' => $reportData['total'],
                        'type' => $infraType,
                        'startDate' => $parsedStartDate,
                        'endDate' => $parsedEndDate
                    ])->render();
                    
                    $allReportsHtml .= $html . '<br><hr />';
                }
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'result' => $allReportsHtml ?: '<div class="alert alert-info text-center"><i class="bi-info-circle me-2"></i>No damages found for any infrastructure type in the selected period.</div>',
                ],
            ]);
        }

        // Original logic for single infrastructure type
        $reportData = $this->generateDistrictWiseForType($type, $parsedStartDate, $parsedEndDate, $districts, $dateType);

        $html = view('modules.dmis.reports.partials.district-wise', [
            'districtStats' => $reportData['districtStats'],
            'total' => $reportData['total'],
            'type' => $type,
            'startDate' => $parsedStartDate,
            'endDate' => $parsedEndDate
        ])->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    private function generateDistrictWiseForType($type, $startDate, $endDate, $districts, $dateType)
    {
        $districtStats = collect();

        foreach ($districts as $district) {
            $infrastructures = $district->infrastructures()
                ->where('type', $type)
                ->get();
            
            $infrastructureIds = $infrastructures->pluck('id')->toArray();
            
            if (empty($infrastructureIds)) {
                continue;
            }
            
            $damageQuery = Damage::whereIn('infrastructure_id', $infrastructureIds);
            
            if ($startDate && $endDate) {
                $damageQuery->whereBetween($dateType, [$startDate, $endDate]);
            }
            
            $damages = $damageQuery->get();

            if ($damages->isEmpty()) {
                continue;
            }

            $stats = [
                'district' => $district,
                'infrastructure_count' => $infrastructures->count(),
                'damaged_infrastructure_count' => $damages->pluck('infrastructure_id')->unique()->count(),
                'damage_count' => $damages->count(),
                'damaged_length' => $damages->sum('damaged_length'),
                'fully_restored' => $damages->where('road_status', 'Fully restored')->count(),
                'partially_restored' => $damages->where('road_status', 'Partially restored')->count(),
                'not_restored' => $damages->where('road_status', 'Not restored')->count(),
                'restoration_cost' => $damages->sum('approximate_restoration_cost'),
                'rehabilitation_cost' => $damages->sum('approximate_rehabilitation_cost'),
                'total_cost' => $damages->sum('approximate_restoration_cost') + $damages->sum('approximate_rehabilitation_cost'),
            ];
            $districtStats->push($stats);
        }

        $districtStats = $districtStats->sortByDesc('damage_count')->values();

        $total = [
            'total_infrastructure_count' => $districtStats->sum('infrastructure_count'),
            'total_damaged_infrastructure_count' => $districtStats->sum('damaged_infrastructure_count'),
            'total_damage_count' => $districtStats->sum('damage_count'),
            'total_damaged_length' => $districtStats->sum('damaged_length'),
            'total_fully_restored' => $districtStats->sum('fully_restored'),
            'total_partially_restored' => $districtStats->sum('partially_restored'),
            'total_not_restored' => $districtStats->sum('not_restored'),
            'total_restoration_cost' => $districtStats->sum('restoration_cost'),
            'total_rehabilitation_cost' => $districtStats->sum('rehabilitation_cost'),
            'total_cost' => $districtStats->sum('total_cost'),
        ];

        return [
            'districtStats' => $districtStats,
            'total' => $total
        ];
    }

    // public function districtWise($type)
    // {
    //     $this->authorize('viewDistrictWiseReport', \App\Models\Damage::class);

    //     $duration = request()->get('duration');
    //     $startDate = request()->get('start_date');
    //     $endDate = request()->get('end_date');
    //     $dateType = request()->get('date_type', 'report_date');
        
    //     // Initialize date variables as null
    //     $parsedStartDate = null;
    //     $parsedEndDate = null;
        
    //     // Only process dates if duration is provided
    //     if (!empty($duration)) {
    //         if ($duration !== 'Custom') {
    //             $parsedEndDate = now()->endOfDay();
    //             $parsedStartDate = now()->subDays((int)$duration)->startOfDay();
    //         } else {
    //             // Custom duration - use provided dates or defaults
    //             $parsedStartDate = $startDate ? Carbon::parse($startDate)->startOfDay() : now()->subDays(30)->startOfDay();
    //             $parsedEndDate = $endDate ? Carbon::parse($endDate)->endOfDay() : now()->endOfDay();
    //         }
    //     }
    //     // If no duration is provided, dates remain null and no date filtering will be applied

    //     $userDistricts = request()->user()->districts();

    //     // Handle "All" type by generating reports for each infrastructure type
    //     if ($type === 'All') {
    //         $infrastructureTypes = setting('infrastructure_type', 'dmis', ['Road', 'Bridge', 'Culvert']);
    //         $allReportsHtml = '';
            
    //         foreach ($infrastructureTypes as $infraType) {
    //             // Generate District Office Report
    //             $districtOfficeReportData = $this->generateDistrictOfficeReport($infraType, $parsedStartDate, $parsedEndDate, $userDistricts, $dateType);
                
    //             if ($districtOfficeReportData['districtStats']->isNotEmpty()) {
    //                 $html = view('modules.dmis.reports.partials.district-wise', [
    //                     'districtStats' => $districtOfficeReportData['districtStats'],
    //                     'total' => $districtOfficeReportData['total'],
    //                     'type' => $infraType,
    //                     'startDate' => $parsedStartDate,
    //                     'endDate' => $parsedEndDate,
    //                     'reportTitle' => 'District Office Report - ' . $infraType
    //                 ])->render();
                    
    //                 $allReportsHtml .= $html;
    //             }
                
    //             // Generate Provincial Office Report
    //             $provincialOfficeReportData = $this->generateProvincialOfficeReport($infraType, $parsedStartDate, $parsedEndDate, $userDistricts, $dateType);
                
    //             if ($provincialOfficeReportData['districtStats']->isNotEmpty()) {
    //                 $html = view('modules.dmis.reports.partials.district-wise', [
    //                     'districtStats' => $provincialOfficeReportData['districtStats'],
    //                     'total' => $provincialOfficeReportData['total'],
    //                     'type' => $infraType,
    //                     'startDate' => $parsedStartDate,
    //                     'endDate' => $parsedEndDate,
    //                     'reportTitle' => 'Provincial Office Report - ' . $infraType
    //                 ])->render();
                    
    //                 $allReportsHtml .= '<br><hr><br>' . $html;
    //             }
                
    //             $allReportsHtml .= '<br><hr><br>';
    //         }
            
    //         return response()->json([
    //             'success' => true,
    //             'data' => [
    //                 'result' => $allReportsHtml ?: '<div class="alert alert-info text-center"><i class="bi-info-circle me-2"></i>No damages found for any infrastructure type in the selected period.</div>',
    //             ],
    //         ]);
    //     }

    //     // Generate District Office Report
    //     $districtOfficeReportData = $this->generateDistrictOfficeReport($type, $parsedStartDate, $parsedEndDate, $userDistricts, $dateType);
        
    //     $districtOfficeHtml = '';
    //     if ($districtOfficeReportData['districtStats']->isNotEmpty()) {
    //         $districtOfficeHtml = view('modules.dmis.reports.partials.district-wise', [
    //             'districtStats' => $districtOfficeReportData['districtStats'],
    //             'total' => $districtOfficeReportData['total'],
    //             'type' => $type,
    //             'startDate' => $parsedStartDate,
    //             'endDate' => $parsedEndDate,
    //             'reportTitle' => 'District Office Report'
    //         ])->render();
    //     }

    //     // Generate Provincial Office Report
    //     $provincialOfficeReportData = $this->generateProvincialOfficeReport($type, $parsedStartDate, $parsedEndDate, $userDistricts, $dateType);
        
    //     $provincialOfficeHtml = '';
    //     if ($provincialOfficeReportData['districtStats']->isNotEmpty()) {
    //         $provincialOfficeHtml = view('modules.dmis.reports.partials.district-wise', [
    //             'districtStats' => $provincialOfficeReportData['districtStats'],
    //             'total' => $provincialOfficeReportData['total'],
    //             'type' => $type,
    //             'startDate' => $parsedStartDate,
    //             'endDate' => $parsedEndDate,
    //             'reportTitle' => 'Provincial Office Report'
    //         ])->render();
    //     }

    //     // Combine reports
    //     $combinedHtml = '';
    //     if (!empty($districtOfficeHtml)) {
    //         $combinedHtml .= $districtOfficeHtml;
    //     }
    //     if (!empty($provincialOfficeHtml)) {
    //         $combinedHtml .= '<br><hr><br>' . $provincialOfficeHtml;
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => [
    //             'result' => $combinedHtml ?: '<div class="alert alert-info text-center"><i class="bi-info-circle me-2"></i>No damages found in the selected period.</div>',
    //         ],
    //     ]);
    // }

    // private function generateDistrictOfficeReport($type, $startDate, $endDate, $userDistricts, $dateType)
    // {
    //     $districtStats = collect();

    //     foreach ($userDistricts as $district) {
    //         $infrastructures = $district->infrastructures()
    //             ->where('type', $type)
    //             ->get();
            
    //         $infrastructureIds = $infrastructures->pluck('id')->toArray();
            
    //         if (empty($infrastructureIds)) {
    //             continue;
    //         }
            
    //         $damageQuery = Damage::whereIn('infrastructure_id', $infrastructureIds);
            
    //         // Filter damages reported by district office users only
    //         if ($district->office) {
    //             $damageQuery->whereHas('posting', function ($query) use ($district) {
    //                 $query->where('office_id', $district->office->id);
    //             });
    //         }
            
    //         if ($startDate && $endDate) {
    //             $damageQuery->whereBetween($dateType, [$startDate, $endDate]);
    //         }
            
    //         $damages = $damageQuery->get();

    //         if ($damages->isEmpty()) {
    //             continue;
    //         }

    //         $stats = [
    //             'district' => $district,
    //             'office' => $district->office,
    //             'display_name' => $district->name,
    //             'office_type' => 'District',
    //             'infrastructure_count' => $infrastructures->count(),
    //             'damaged_infrastructure_count' => $damages->pluck('infrastructure_id')->unique()->count(),
    //             'damage_count' => $damages->count(),
    //             'damaged_length' => $damages->sum('damaged_length'),
    //             'fully_restored' => $damages->where('road_status', 'Fully restored')->count(),
    //             'partially_restored' => $damages->where('road_status', 'Partially restored')->count(),
    //             'not_restored' => $damages->where('road_status', 'Not restored')->count(),
    //             'restoration_cost' => $damages->sum('approximate_restoration_cost'),
    //             'rehabilitation_cost' => $damages->sum('approximate_rehabilitation_cost'),
    //             'total_cost' => $damages->sum('approximate_restoration_cost') + $damages->sum('approximate_rehabilitation_cost'),
    //         ];
    //         $districtStats->push($stats);
    //     }

    //     $districtStats = $districtStats->sortByDesc('damage_count')->values();

    //     $total = [
    //         'total_infrastructure_count' => $districtStats->sum('infrastructure_count'),
    //         'total_damaged_infrastructure_count' => $districtStats->sum('damaged_infrastructure_count'),
    //         'total_damage_count' => $districtStats->sum('damage_count'),
    //         'total_damaged_length' => $districtStats->sum('damaged_length'),
    //         'total_fully_restored' => $districtStats->sum('fully_restored'),
    //         'total_partially_restored' => $districtStats->sum('partially_restored'),
    //         'total_not_restored' => $districtStats->sum('not_restored'),
    //         'total_restoration_cost' => $districtStats->sum('restoration_cost'),
    //         'total_rehabilitation_cost' => $districtStats->sum('rehabilitation_cost'),
    //         'total_cost' => $districtStats->sum('total_cost'),
    //     ];

    //     return [
    //         'districtStats' => $districtStats,
    //         'total' => $total
    //     ];
    // }

    // private function generateProvincialOfficeReport($type, $startDate, $endDate, $userDistricts, $dateType)
    // {
    //     $districtStats = collect();
        
    //     // Get all provincial offices
    //     $provincialOffices = Office::where('type', 'Provincial')->get();
        
    //     foreach ($provincialOffices as $provincialOffice) {
    //         $managedDistricts = $provincialOffice->getAllManagedDistricts();
            
    //         foreach ($managedDistricts as $district) {
    //             // Only include if this district is in user's accessible districts
    //             if (!$userDistricts->contains('id', $district->id)) {
    //                 continue;
    //             }
                
    //             $infrastructures = $district->infrastructures()
    //                 ->where('type', $type)
    //                 ->get();
                
    //             $infrastructureIds = $infrastructures->pluck('id')->toArray();
                
    //             if (empty($infrastructureIds)) {
    //                 continue;
    //             }
                
    //             $damageQuery = Damage::whereIn('infrastructure_id', $infrastructureIds);
                
    //             // Filter damages reported by provincial office users only
    //             $damageQuery->whereHas('posting', function ($query) use ($provincialOffice) {
    //                 $query->where('office_id', $provincialOffice->id);
    //             });
                
    //             if ($startDate && $endDate) {
    //                 $damageQuery->whereBetween($dateType, [$startDate, $endDate]);
    //             }
                
    //             $damages = $damageQuery->get();

    //             if ($damages->isEmpty()) {
    //                 continue;
    //             }

    //             $stats = [
    //                 'district' => $district,
    //                 'office' => $provincialOffice,
    //                 'display_name' => $district->name . ' (' . $provincialOffice->name . ')',
    //                 'office_type' => 'Provincial',
    //                 'infrastructure_count' => $infrastructures->count(),
    //                 'damaged_infrastructure_count' => $damages->pluck('infrastructure_id')->unique()->count(),
    //                 'damage_count' => $damages->count(),
    //                 'damaged_length' => $damages->sum('damaged_length'),
    //                 'fully_restored' => $damages->where('road_status', 'Fully restored')->count(),
    //                 'partially_restored' => $damages->where('road_status', 'Partially restored')->count(),
    //                 'not_restored' => $damages->where('road_status', 'Not restored')->count(),
    //                 'restoration_cost' => $damages->sum('approximate_restoration_cost'),
    //                 'rehabilitation_cost' => $damages->sum('approximate_rehabilitation_cost'),
    //                 'total_cost' => $damages->sum('approximate_restoration_cost') + $damages->sum('approximate_rehabilitation_cost'),
    //             ];
    //             $districtStats->push($stats);
    //         }
    //     }

    //     $districtStats = $districtStats->sortByDesc('damage_count')->values();

    //     $total = [
    //         'total_infrastructure_count' => $districtStats->sum('infrastructure_count'),
    //         'total_damaged_infrastructure_count' => $districtStats->sum('damaged_infrastructure_count'),
    //         'total_damage_count' => $districtStats->sum('damage_count'),
    //         'total_damaged_length' => $districtStats->sum('damaged_length'),
    //         'total_fully_restored' => $districtStats->sum('fully_restored'),
    //         'total_partially_restored' => $districtStats->sum('partially_restored'),
    //         'total_not_restored' => $districtStats->sum('not_restored'),
    //         'total_restoration_cost' => $districtStats->sum('restoration_cost'),
    //         'total_rehabilitation_cost' => $districtStats->sum('rehabilitation_cost'),
    //         'total_cost' => $districtStats->sum('total_cost'),
    //     ];

    //     return [
    //         'districtStats' => $districtStats,
    //         'total' => $total
    //     ];
    // }

    public function districtDetailsReport(Request $request, District $district)
    {
        $this->authorize('viewDistrictWiseReport', \App\Models\Damage::class);

        $type = $request->get('type') ?? 'Road';
        $user = $request->get('user');

        $posting = User::findOrFail($user)->getSubordinates;
        $infrastructures = $district->infrastructures()
            ->when($type !== 'All', function ($query) use ($type) {
                return $query->where('type', $type);
            })
            ->get();
            dd($posting);
        $infrastructureIds = $infrastructures->pluck('id')->toArray();

        $damages = Damage::whereIn('infrastructure_id', $infrastructureIds)
            ->where('posting_id', $posting->id)
            ->with([
                'infrastructure',
                'posting.user.currentDesignation',
                'posting.office',
                'media'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $damagesByInfrastructure = $damages->groupBy('infrastructure_id');

        $stats = [
            'total_damages' => $damages->count(),
            'unique_infrastructures' => $damages->pluck('infrastructure_id')->unique()->count(),
            'total_damaged_length' => $damages->sum('damaged_length'),
            'fully_restored' => $damages->where('road_status', 'Fully restored')->count(),
            'partially_restored' => $damages->where('road_status', 'Partially restored')->count(),
            'not_restored' => $damages->where('road_status', 'Not restored')->count(),
            'total_restoration_cost' => $damages->sum('approximate_restoration_cost'),
            'total_rehabilitation_cost' => $damages->sum('approximate_rehabilitation_cost'),
            'total_cost' => $damages->sum('approximate_restoration_cost') + $damages->sum('approximate_rehabilitation_cost'),
        ];

        $reportingOfficers = $damages->map(function ($damage) {
            return [
                'user' => $damage->posting->user ?? null,
                'office' => $damage->posting->office ?? null,
                'designation' => $damage->posting->user->currentDesignation ?? null,
                'damage_count' => 1
            ];
        })->filter(function ($officer) {
            return $officer['user'] !== null;
        })->groupBy('user.id')->map(function ($group) {
            $first = $group->first();
            return [
                'user' => $first['user'],
                'office' => $first['office'],
                'designation' => $first['designation'],
                'damage_count' => $group->count()
            ];
        })->values();

        return view('modules.dmis.reports.district-details', compact(
            'district',
            'damages',
            'damagesByInfrastructure',
            'stats',
            'reportingOfficers',
            'type'
        ));
    }
}
