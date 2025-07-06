<?php

namespace App\Http\Controllers\Site;

use Carbon\Carbon;
use App\Models\Damage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\District;

class DamageController extends Controller
{
    public function index(Request $request)
    {
        $report_type = $request->get('report_type') ?? 'Summary';
        $type = $request->get('type') ?? 'Road';
        $userId = $request->get('user_id') ?? 4;
        
        $duration = request()->get('duration');
        $startDate = request()->get('start_date');
        $endDate = request()->get('end_date');
        
        if ($duration && $duration !== 'Custom') {
            $endDate = now()->format('Y-m-d');
            $startDate = now()->subDays((int)$duration)->format('Y-m-d');
        } else {
            $startDate = $startDate ?: now()->subDays(30)->format('Y-m-d');
            $endDate = $endDate ?: now()->format('Y-m-d');
        }
        
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $districts = District::all();

        $districtStats = collect();

        foreach ($districts as $district) {
            $infrastructures = $district->infrastructures()
                ->when($type !== 'All', function ($query) use ($type) {
                    return $query->where('type', $type);
                })
                ->get();
            
            $infrastructureIds = $infrastructures->pluck('id')->toArray();
            
            if (empty($infrastructureIds)) {
                continue;
            }
            
            $damageQuery = Damage::whereIn('infrastructure_id', $infrastructureIds)
                ->whereBetween('created_at', [$startDate, $endDate]); // Add date range filter
            
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

        return view('site.dmis.index', compact(
            'districtStats', 
            'total', 
            'type',
            'startDate',
            'endDate'
        ));
    }

    public function districtDetail(Request $request, $name)
    {

        $type = $request->get('type') ?? 'Road';

        $district = District::where('name', $name)->firstOrFail();
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

        return view('site.dmis.district', compact(
            'district',
            'damages',
            'damagesByInfrastructure',
            'stats',
            'reportingOfficers',
            'type'
        ));
    }
}
