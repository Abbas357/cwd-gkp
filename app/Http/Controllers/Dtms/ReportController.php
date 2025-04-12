<?php

namespace App\Http\Controllers\Dtms;

use App\Models\User;
use App\Models\Damage;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type') ?? 'Road';
        $userId = $request->get('user_id') ?? 4;
        $selectedUser = User::findOrFail($userId);
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
            
            $subordinateDistricts = $subordinate->districts();
            
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
                
                $district->fully_restored = $damageQuery->clone()->where('road_status', 'Fully restored')->count();
                $district->partially_restored = $damageQuery->clone()->where('road_status', 'Partially restored')->count();
                $district->not_restored = $damageQuery->clone()->where('road_status', 'Not restored')->count();

                $district->restoration = $damageQuery->clone()->sum('approximate_restoration_cost');
                $district->rehabilitation = $damageQuery->clone()->sum('approximate_rehabilitation_cost');
                
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
        
        return view('modules.dtms.reports.main', compact(
            'subordinatesWithDistricts', 
            'total', 
            'subordinateDesignation', 
            'selectedUser'
        ));
    }

    public function officerReport(Request $request)
    {
        $type = $request->get('type') ?? 'Road';
        
        $officers = User::whereHas('postings', function($query) {
            $query->where('is_current', true)
                ->whereNotNull('office_id');
        })->with(['currentPosting', 'currentOffice', 'currentDesignation'])
        ->get();
        
        $officerStats = collect();
        
        foreach ($officers as $officer) {
            $postingId = $officer->currentPosting?->id;
            
            if (!$postingId) {
                continue;
            }            
            
            $damageQuery = Damage::where('posting_id', $postingId);
            
            if ($type !== 'All') {
                $damageQuery->whereHas('infrastructure', function($query) use ($type) {
                    $query->where('type', $type);
                });
            }
            
            $damages = $damageQuery->get();
            
            if ($damages->isEmpty()) {
                continue;
            }            
            
            $stats = [
                'officer' => $officer,
                'damage_count' => $damages->count(),
                'distinct_infrastructure_count' => $damages->pluck('infrastructure_id')->unique()->count(),
                'fully_restored' => $damages->where('road_status', 'Fully restored')->count(),
                'partially_restored' => $damages->where('road_status', 'Partially restored')->count(),
                'not_restored' => $damages->where('road_status', 'Not restored')->count(),
                'restoration_cost' => $damages->sum('approximate_restoration_cost'),
                'rehabilitation_cost' => $damages->sum('approximate_rehabilitation_cost'),
                'total_cost' => $damages->sum('approximate_restoration_cost') + $damages->sum('approximate_rehabilitation_cost'),
                'last_reported' => $damages->max('created_at'),
            ];
            
            $officerStats->push($stats);
        }
        
        $officerStats = $officerStats->sortByDesc('damage_count')->values();
        
        $total = [
            'total_damage_count' => $officerStats->sum('damage_count'),
            'total_infrastructure_count' => $officerStats->sum('distinct_infrastructure_count'),
            'total_fully_restored' => $officerStats->sum('fully_restored'),
            'total_partially_restored' => $officerStats->sum('partially_restored'),
            'total_not_restored' => $officerStats->sum('not_restored'),
            'total_restoration_cost' => $officerStats->sum('restoration_cost'),
            'total_rehabilitation_cost' => $officerStats->sum('rehabilitation_cost'),
            'total_cost' => $officerStats->sum('total_cost'),
        ];
        
        return view('modules.dtms.reports.officer-wise', compact('officerStats', 'total', 'type'));
    }

    
    public function districtDamagesReport(Request $request)
    {
        $type = $request->get('type') ?? 'Road';        
        
        $districts = District::with('infrastructures')->get();
        
        $districtStats = collect();
        
        foreach ($districts as $district) {
            
            $infrastructures = $district->infrastructures()
                ->when($type !== 'All', function($query) use ($type) {
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
        
        return view('modules.dtms.reports.district-wise', compact('districtStats', 'total', 'type'));
    }

    
    public function highCostDistrictsReport(Request $request)
    {
        $type = $request->get('type') ?? 'Road';
        $costType = $request->get('cost_type') ?? 'total'; 
        $districts = District::with('infrastructures')->get();
        $districtStats = collect();
        
        foreach ($districts as $district) {
            $infrastructures = $district->infrastructures()
                ->when($type !== 'All', function($query) use ($type) {
                    return $query->where('type', $type);
                })
                ->get();
            $infrastructureIds = $infrastructures->pluck('id')->toArray();
            $damageQuery = Damage::whereIn('infrastructure_id', $infrastructureIds);
            $damages = $damageQuery->get();
            if ($damages->isEmpty()) {
                
                $stats = [
                    'district' => $district,
                    'damage_count' => 0,
                    'restoration_cost' => 0,
                    'rehabilitation_cost' => 0,
                    'total_cost' => 0,
                ];
                $districtStats->push($stats);
                continue;
            }            
            
            $stats = [
                'district' => $district,
                'damage_count' => $damages->count(),
                'restoration_cost' => $damages->sum('approximate_restoration_cost'),
                'rehabilitation_cost' => $damages->sum('approximate_rehabilitation_cost'),
                'total_cost' => $damages->sum('approximate_restoration_cost') + $damages->sum('approximate_rehabilitation_cost'),
            ];
            
            $districtStats->push($stats);
        }
        
        switch ($costType) {
            case 'restoration':
                $districtStats = $districtStats->sortByDesc('restoration_cost')->values();
                break;
            case 'rehabilitation':
                $districtStats = $districtStats->sortByDesc('rehabilitation_cost')->values();
                break;
            case 'total':
            default:
                $districtStats = $districtStats->sortByDesc('total_cost')->values();
                break;
        }
        
        $total = [
            'total_damage_count' => $districtStats->sum('damage_count'),
            'total_restoration_cost' => $districtStats->sum('restoration_cost'),
            'total_rehabilitation_cost' => $districtStats->sum('rehabilitation_cost'),
            'total_cost' => $districtStats->sum('total_cost'),
        ];
        
        return view('modules.dtms.reports.highly-damaged', compact('districtStats', 'total', 'type', 'costType'));
    }

    public function activeOfficersReport(Request $request)
    {
        $type = $request->get('type') ?? 'Road';
        $period = $request->get('period') ?? 30; 
        
        $startDate = now()->subDays($period);
        
        $officers = User::whereHas('postings', function($query) {
            $query->where('is_current', true)
                ->whereNotNull('office_id');
        })->with(['currentPosting', 'currentOffice', 'currentDesignation'])
        ->get();
        
        $officerStats = collect();
        
        foreach ($officers as $officer) {
            $postingId = $officer->currentPosting?->id;
            
            if (!$postingId) {
                continue;
            }            
            
            $damageQuery = Damage::where('posting_id', $postingId)
                ->where('created_at', '>=', $startDate);
            
            if ($type !== 'All') {
                $damageQuery->whereHas('infrastructure', function($query) use ($type) {
                    $query->where('type', $type);
                });
            }
            
            $recentDamages = $damageQuery->get();    
            $allDamageQuery = Damage::where('posting_id', $postingId);
            
            if ($type !== 'All') {
                $allDamageQuery->whereHas('infrastructure', function($query) use ($type) {
                    $query->where('type', $type);
                });
            }
            
            $allDamages = $allDamageQuery->get();
            
            $stats = [
                'officer' => $officer,
                'recent_damage_count' => $recentDamages->count(),
                'all_damage_count' => $allDamages->count(),
                'last_activity' => $allDamages->max('created_at'),
                'assigned_districts' => $officer->districts() ?? collect(),
                'recent_restoration_cost' => $recentDamages->sum('approximate_restoration_cost'),
                'recent_rehabilitation_cost' => $recentDamages->sum('approximate_rehabilitation_cost'),
                'recent_total_cost' => $recentDamages->sum('approximate_restoration_cost') + $recentDamages->sum('approximate_rehabilitation_cost'),
            ];
            
            $officerStats->push($stats);
        }
        
        $officerStats = $officerStats->sortByDesc('recent_damage_count')->values();
        
        $total = [
            'total_recent_damage_count' => $officerStats->sum('recent_damage_count'),
            'total_all_damage_count' => $officerStats->sum('all_damage_count'),
            'total_recent_restoration_cost' => $officerStats->sum('recent_restoration_cost'),
            'total_recent_rehabilitation_cost' => $officerStats->sum('recent_rehabilitation_cost'),
            'total_recent_cost' => $officerStats->sum('recent_total_cost'),
        ];
        
        return view('modules.dtms.reports.active-officers', compact('officerStats', 'total', 'type', 'period'));
    }
}