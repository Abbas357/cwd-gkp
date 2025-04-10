<?php

namespace App\Http\Controllers\Dts;

use App\Models\User;
use App\Models\Damage;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index()
    {
        $type = request()->get('type') ?? 'Road';
        $userId = request()->get('user_id') ?? 4;
        
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
            
            // Get districts managed by this subordinate
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
                
                // Calculate statistics for the district
                $district->damaged_infrastructure_count = Damage::whereIn('infrastructure_id', $infraIds)
                    ->distinct('infrastructure_id')
                    ->count('infrastructure_id');
                    
                // Skip districts with no damages
                if ($district->damaged_infrastructure_count == 0) {
                    continue;
                }
    
                $district->damaged_infrastructure_total_count = $district->infrastructures->where('type', $type)
                    ->whereIn('id', Damage::whereIn('infrastructure_id', $infraIds)->pluck('infrastructure_id')
                    ->unique()
                    ->toArray())
                    ->sum('length');
    
                $district->damaged_infrastructure_sum = Damage::whereIn('infrastructure_id', $infraIds)
                    ->sum('damaged_length');
    
                $district->fully_restored = Damage::whereIn('infrastructure_id', $infraIds)
                    ->where('road_status', 'Fully restored')
                    ->count();
    
                $district->partially_restored = Damage::whereIn('infrastructure_id', $infraIds)
                    ->where('road_status', 'Partially restored')
                    ->count();
    
                $district->not_restored = Damage::whereIn('infrastructure_id', $infraIds)
                    ->where('road_status', 'Not restored')
                    ->count();
    
                $district->restoration = Damage::whereIn('infrastructure_id', $infraIds)
                    ->sum('approximate_restoration_cost');
    
                $district->rehabilitation = Damage::whereIn('infrastructure_id', $infraIds)
                    ->sum('approximate_rehabilitation_cost');
                
                // Add district to the collection
                $districts->push($district);
                
                // Update totals
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
        
        return view('modules.dts.damages.report', compact('subordinatesWithDistricts', 'total', 'subordinateDesignation', 'selectedUser'));
    }
}