<?php

namespace App\Http\Controllers\dmis;

use App\Models\User;
use App\Models\Damage;
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

        $selectedUser = User::findOrFail($userId);

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
                'selectedUser' => $selectedUser
            ]);
        }

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
                $damageQuery = Damage::whereIn('infrastructure_id', $infraIds)
                    ->whereIn('posting_id', $teamPostingIds);

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

        $html =  view('modules.dmis.reports.partials.summary', compact(
            'subordinatesWithDistricts',
            'total',
            'subordinateDesignation',
            'selectedUser',
            'type'
        ))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function dailySituation($type, $reportDate, $userId)
    {
        $this->authorize('viewSituationReport', \App\Models\Damage::class);

        $selectedUser = User::findOrFail($userId);
        $officerDistricts = $selectedUser->districts();

        if ($officerDistricts->isEmpty()) {
            return view('modules.dmis.reports.daily-situation', [
                'subordinatesWithDistricts' => collect(),
                'total' => [
                    'totalDamagedInfrastructureCount' => 0,
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
                'reportDate' => $reportDate
            ]);
        }

        $directSubordinates = $selectedUser->getDirectSubordinates();

        $totalDamagedInfrastructureCount = 0;
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
                    ->whereDate('created_at', $reportDate); // Filter by date

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

        $html = view('modules.dmis.reports.partials.daily-situation', compact(
            'subordinatesWithDistricts',
            'total',
            'subordinateDesignation',
            'selectedUser',
            'reportDate',
            'type'
        ))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function districtWise($type)
    {
        $this->authorize('viewDistrictWiseReport', \App\Models\Damage::class);

        $districts = request()->user()->districts();

        $districtStats = collect();

        foreach ($districts as $district) {
            $infrastructures = $district->infrastructures()
                ->when($type !== 'All', function ($query) use ($type) {
                    return $query->where('type', $type);
                })
                ->get();
            $infrastructureIds = $infrastructures->pluck('id')->toArray();
            $damageQuery = Damage::whereIn('infrastructure_id', $infrastructureIds);
            $damages = $damageQuery->get();

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

        $html = view('modules.dmis.reports.partials.district-wise', compact('districtStats', 'total', 'type'))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function districtDetailsReport(Request $request, District $district)
    {
        $this->authorize('viewDistrictWiseReport', \App\Models\Damage::class);

        $type = $request->get('type') ?? 'Road';

        $infrastructures = $district->infrastructures()
            ->when($type !== 'All', function ($query) use ($type) {
                return $query->where('type', $type);
            })
            ->get();

        $infrastructureIds = $infrastructures->pluck('id')->toArray();

        $damages = Damage::whereIn('infrastructure_id', $infrastructureIds)
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
