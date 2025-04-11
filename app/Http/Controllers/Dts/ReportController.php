<?php

namespace App\Http\Controllers\Dts;

use App\Models\User;
use App\Models\Damage;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters from request
        $type = $request->get('type') ?? 'Road';
        $userId = $request->get('user_id') ?? 4;
        
        // Find the selected user
        $selectedUser = User::findOrFail($userId);
        
        // Get direct subordinates of the selected user
        $directSubordinates = $selectedUser->getDirectSubordinates();
        
        // Initialize totals for report
        $totalDamagedInfrastructureCount = 0;
        $totalDamagedInfrastructureSum = 0;
        $totalDamagedInfrastructureTotalCount = 0;
        $totalFullyRestored = 0;
        $totalPartiallyRestored = 0;
        $totalNotRestored = 0;
        $totalRestorationCost = 0;
        $totalRehabilitationCost = 0;
        
        $subordinatesWithDistricts = collect();

        // Process each subordinate
        foreach ($directSubordinates as $subordinate) {
            // Get the current posting ID of the subordinate
            $subordinatePostingId = $subordinate->currentPosting?->id;
            
            if (!$subordinatePostingId) {
                continue; // Skip if subordinate has no current posting
            }
            
            // Get districts managed by this subordinate
            $subordinateDistricts = $subordinate->districts();
            
            if ($subordinateDistricts->isEmpty()) {
                continue; // Skip if subordinate manages no districts
            }
            
            $districts = collect();
            
            // Process each district
            foreach ($subordinateDistricts as $district) {
                // Get infrastructure IDs for this district and type
                $infraIds = $district->infrastructures
                    ->where('type', $type)
                    ->pluck('id')
                    ->toArray();
                
                if (empty($infraIds)) {
                    continue; // Skip if no matching infrastructure
                }
                
                $subordinateTeam = $subordinate->getSubordinates();
                
                // Include the subordinate's own posting ID in the team posting IDs
                $teamPostingIds = $subordinateTeam->pluck('currentPosting.id')->filter()->toArray();
                $teamPostingIds[] = $subordinatePostingId;
                
                // Filter damages by infrastructure ID AND any posting ID in the subordinate's command chain
                $damageQuery = Damage::whereIn('infrastructure_id', $infraIds)
                    ->whereIn('posting_id', $teamPostingIds);
                // Count unique infrastructures with damages for this posting
                $district->damaged_infrastructure_count = $damageQuery->distinct('infrastructure_id')
                    ->count('infrastructure_id');
                    
                // Skip districts with no damages for this subordinate
                if ($district->damaged_infrastructure_count == 0) {
                    continue;
                }
                
                // Get damaged infrastructure IDs specific to this subordinate
                $damagedInfraIds = $damageQuery->pluck('infrastructure_id')->unique()->toArray();
                
                // Calculate total length of affected infrastructure
                $district->damaged_infrastructure_total_count = $district->infrastructures
                    ->where('type', $type)
                    ->whereIn('id', $damagedInfraIds)
                    ->sum('length');
                
                // Calculate total damage length
                $district->damaged_infrastructure_sum = $damageQuery->clone()->sum('damaged_length');
                // Count damages by road status
                $district->fully_restored = $damageQuery->clone()->where('road_status', 'Fully restored')->count();
                $district->partially_restored = $damageQuery->clone()->where('road_status', 'Partially restored')->count();
                $district->not_restored = $damageQuery->clone()->where('road_status', 'Not restored')->count();

                // Calculate costs
                $district->restoration = $damageQuery->clone()->sum('approximate_restoration_cost');
                $district->rehabilitation = $damageQuery->clone()->sum('approximate_rehabilitation_cost');
                
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
            
            // Add subordinate with their districts to the collection if they have any
            if ($districts->isNotEmpty()) {
                $subordinatesWithDistricts->push([
                    'subordinate' => $subordinate,
                    'districts' => $districts,
                    'district_count' => $districts->count()
                ]);
            }
        }
        
        // Prepare total summary
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
        
        // Determine subordinate designation for display
        $subordinateDesignation = "Officer";
        if ($directSubordinates->isNotEmpty() && $directSubordinates->first()->currentDesignation) {
            $subordinateDesignation = $directSubordinates->first()->currentDesignation->name;
        }
        
        return view('modules.dts.damages.report', compact(
            'subordinatesWithDistricts', 
            'total', 
            'subordinateDesignation', 
            'selectedUser'
        ));
    }
}