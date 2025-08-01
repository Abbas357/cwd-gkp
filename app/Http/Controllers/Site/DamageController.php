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
        
        $parsedStartDate = null;
        $parsedEndDate = null;
        
        if (!empty($duration)) {
            if ($duration !== 'Custom') {
                $parsedEndDate = now()->endOfDay();
                $parsedStartDate = now()->subDays((int)$duration)->startOfDay();
            } else {
                $parsedStartDate = $startDate ? Carbon::parse($startDate)->startOfDay() : now()->subDays(30)->startOfDay();
                $parsedEndDate = $endDate ? Carbon::parse($endDate)->endOfDay() : now()->endOfDay();
            }
        }

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
            
            $damageQuery = Damage::whereIn('infrastructure_id', $infrastructureIds);
            
            if ($parsedStartDate && $parsedEndDate) {
                $damageQuery->whereBetween('report_date', [$parsedStartDate, $parsedEndDate]);
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
        ];

        return view('site.dmis.index', compact(
            'districtStats', 
            'total', 
            'type',
            'parsedStartDate',
            'parsedEndDate'
        ));
    }

    public function districtDetail(Request $request, $name)
    {
        $type = $request->get('type') ?? 'Road';
        $dateType = $request->get('date_type', 'created_at');
        
        $duration = request()->get('duration');
        $startDate = request()->get('start_date');
        $endDate = request()->get('end_date');
        
        $parsedStartDate = null;
        $parsedEndDate = null;
        
        if (!empty($duration)) {
            if ($duration !== 'Custom') {
                $parsedEndDate = now()->endOfDay();
                $parsedStartDate = now()->subDays((int)$duration)->startOfDay();
            } else {
                $parsedStartDate = $startDate ? Carbon::parse($startDate)->startOfDay() : now()->subDays(30)->startOfDay();
                $parsedEndDate = $endDate ? Carbon::parse($endDate)->endOfDay() : now()->endOfDay();
            }
        }

        $district = District::where('name', $name)->firstOrFail();
        $infrastructures = $district->infrastructures()
            ->when($type !== 'All', function ($query) use ($type) {
                return $query->where('type', $type);
            })
            ->get();

        $infrastructureIds = $infrastructures->pluck('id')->toArray();

        $damageQuery = Damage::whereIn('infrastructure_id', $infrastructureIds);
        
        if ($parsedStartDate && $parsedEndDate) {
            $damageQuery->whereBetween('report_date', [$parsedStartDate, $parsedEndDate]);
        }
        
        $damages = $damageQuery->with([
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
            'type',
            'parsedStartDate',
            'parsedEndDate'
        ));
    }
}