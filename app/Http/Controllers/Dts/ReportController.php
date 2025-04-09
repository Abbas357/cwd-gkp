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
        $userId = request('user_id');
        
        if (!empty(request('user_id'))) {
            $districts = User::findOrFail($userId)?->districts();
        } else {
            $districts = request()->user()->districts();
        }

        // Initialize totals
        $totalDamagedInfrastructureCount = 0;
        $totalDamagedInfrastructureSum = 0;
        $totalDamagedInfrastructureTotalCount = 0;
        $totalFullyRestored = 0;
        $totalPartiallyRestored = 0;
        $totalNotRestored = 0;
        $totalRestorationCost = 0;
        $totalRehabilitationCost = 0;

        $districts->each(function ($district) use (&$type, &$totalDamagedInfrastructureCount, &$totalDamagedInfrastructureSum, &$totalDamagedInfrastructureTotalCount, &$totalFullyRestored, &$totalPartiallyRestored, &$totalNotRestored, &$totalRestorationCost, &$totalRehabilitationCost) {
            $district->chiefEngineer = $district->office->getAncestors()->where('type', 'Regional')->first();
            // dd($district->chiefEngineer);

            $infraIds = $district->infrastructures
                ->where('type', $type)
                ->pluck('id')
                ->toArray();

            $district->damaged_infrastructure_count = Damage::whereIn('infrastructure_id', $infraIds)
                ->distinct('infrastructure_id')
                ->count('infrastructure_id');

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

            // Update totals
            $totalDamagedInfrastructureCount += $district->damaged_infrastructure_count;
            $totalDamagedInfrastructureSum += $district->damaged_infrastructure_sum;
            $totalDamagedInfrastructureTotalCount += $district->damaged_infrastructure_total_count;
            $totalFullyRestored += $district->fully_restored;
            $totalPartiallyRestored += $district->partially_restored;
            $totalNotRestored += $district->not_restored;
            $totalRestorationCost += $district->restoration;
            $totalRehabilitationCost += $district->rehabilitation;
        });

        // Filter districts with totalDamagedInfrastructureCount > 0
        $districts = $districts->filter(function ($district) {
            return $district->damaged_infrastructure_count > 0;
        });

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
        return view('modules.dts.damages.report', compact('districts', 'total'));
    }
}
