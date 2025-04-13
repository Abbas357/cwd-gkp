<?php

namespace App\Http\Controllers\Dtms;

use App\Models\Damage;
use App\Models\Setting;
use App\Models\District;
use Illuminate\Http\Request;
use App\Models\Infrastructure;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $module = 'dtms';

    public function dashboard(Request $request)
    {
        $type = $request->get('type', 'Road');
        
        $totalInfrastructure = Infrastructure::where('type', $type)->count();
        $totalDamages = Damage::where('type', $type)
            ->count();
        
        $fullyDamaged = Damage::where('type', $type)
            ->where('damage_status', 'Fully Damaged')
            ->count();
        
        $partiallyDamaged = Damage::where('type', $type)
            ->where('damage_status', 'Partially Damaged')
            ->count();
        
        $fullyRestored = Damage::where('type', $type)
            ->where('road_status', 'Fully restored')
            ->count();
        
        $partiallyRestored = Damage::where('type', $type)
            ->where('road_status', 'Partially restored')
            ->count();
        
        $notRestored = Damage::where('type', $type)
            ->where('road_status', 'Not restored')
            ->count();
        
        $totalRestorationCost = Damage::where('type', $type)
            ->sum('approximate_restoration_cost');
        
        $totalRehabilitationCost = Damage::where('type', $type)
            ->sum('approximate_rehabilitation_cost');
        
        $districtsWithStats = District::withCount([
            'infrastructures as infrastructure_count' => function($query) use ($type) {
                $query->where('type', $type);
            },
            'infrastructures as total_length' => function($query) use ($type) {
                $query->where('type', $type);
                $query->select(DB::raw('SUM(length)'));
            }
        ])
        ->with(['infrastructures' => function($query) use ($type) {
            $query->where('type', $type);
        }])
        ->get();
        
        foreach ($districtsWithStats as $district) {
            
            $infrastructureIds = $district->infrastructures->pluck('id')->toArray();            
            
            $district->damage_count = Damage::where('type', $type)
                ->whereIn('infrastructure_id', $infrastructureIds)
                ->count();            
            
            $district->damaged_length = Damage::where('type', $type)
                ->whereIn('infrastructure_id', $infrastructureIds)
                ->sum('damaged_length');            
            
            $district->restoration_cost = Damage::where('type', $type)
                ->whereIn('infrastructure_id', $infrastructureIds)
                ->sum('approximate_restoration_cost');            
            
            $district->rehabilitation_cost = Damage::where('type', $type)
                ->whereIn('infrastructure_id', $infrastructureIds)
                ->sum('approximate_rehabilitation_cost');
                
            
            $district->fully_restored = Damage::where('type', $type)
                ->whereIn('infrastructure_id', $infrastructureIds)
                ->where('road_status', 'Fully restored')
                ->count();
                
            $district->partially_restored = Damage::where('type', $type)
                ->whereIn('infrastructure_id', $infrastructureIds)
                ->where('road_status', 'Partially restored')
                ->count();
                
            $district->not_restored = Damage::where('type', $type)
                ->whereIn('infrastructure_id', $infrastructureIds)
                ->where('road_status', 'Not restored')
                ->count();
        }       
        
        $districtsWithStats = $districtsWithStats->sortByDesc('damage_count');
        
        $recentDamages = Damage::with(['infrastructure', 'posting.user', 'district'])
            ->where('type', $type)
            ->latest()
            ->take(5)
            ->get();
        
        $mostAffectedDistricts = $districtsWithStats->take(5);
        
        $highestRestorationCostDistricts = $districtsWithStats->sortByDesc('restoration_cost')->take(5);
        
        $damagesByMonth = Damage::where('type', $type)
            ->select(DB::raw('MONTH(report_date) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        
        $months = [];
        $damageCounts = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('M', mktime(0, 0, 0, $i, 1));
            $months[] = $monthName;
            
            $found = false;
            foreach ($damagesByMonth as $damage) {
                if ($damage->month == $i) {
                    $damageCounts[] = $damage->count;
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $damageCounts[] = 0;
            }
        }
        return view('modules.dtms.home.dashboard', compact(
            'type',
            'totalInfrastructure',
            'totalDamages',
            'fullyDamaged',
            'partiallyDamaged',
            'fullyRestored',
            'partiallyRestored',
            'notRestored',
            'totalRestorationCost',
            'totalRehabilitationCost',
            'districtsWithStats',
            'recentDamages',
            'mostAffectedDistricts',
            'highestRestorationCostDistricts',
            'months',
            'damageCounts',
        ));
    }

    public function settings()
    {
        $this->initIfNeeded();
        $years = $this->years();
        $activityTypes = [
            'Monsoon',
            'Flood',
            'Earthquake',
            'Landslide',
            'Snowfall',
            'Avalanche',
        ];

        return view('modules.dtms.home.settings', compact('activityTypes', 'years'));
    }

    public function update(Request $request)
    {
        if ($request->has('settings')) {
            foreach ($request->settings as $key => $data) {
                if (!isset($data['value']) && $data['type'] !== 'boolean') {
                    continue;
                }

                Setting::set(
                    $key,
                    $data['value'],
                    $this->module,
                    'string',
                    $key . ' for ' . $this->module
                );
            }
        }

        if ($request->has('categories')) {
            foreach ($request->categories as $key => $data) {
                if (!isset($data['value']) || !is_array($data['value'])) {
                    continue;
                }
                $items = array_values(array_filter($data['value']));
                Setting::set(
                    $key,
                    $items,
                    $this->module,
                    'category',
                    $data['description'] ?? null
                );
            }
        }

        return redirect()->route('admin.apps.dtms.settings.index')
            ->with('success', 'DTMS settings updated successfully.');
    }

    public function init()
    {
        Setting::set('activity', 'Monsoon', $this->module);
        Setting::set('session', date('Y'), $this->module);

        Setting::set('road_status', [
            'Partially restored', 'Fully restored', 'Not restored'
        ], $this->module, 'category', 'Types of Road Status');
        Setting::set('infrastructure_type', [
            'Road', 'Bridge', 'Culvert'
        ], $this->module, 'category', 'Types of Infrastructures');
        Setting::set('damage_status', [
            'Partially Damaged', 'Fully Damaged'
        ], $this->module, 'category', 'Types of Damage Status');
        Setting::set('damage_nature', [
            'Culvert', 'Retaining Wall', 'Embankment Damages', 'Shoulders', 'WC',
            'Base Course', 'Sub Base', 'Culverts', 'Rigid Pavement', 'Kacha Road',
            'Structure work & Approach', 'Road washed away', 'Land Sliding',
            'Surface of road', 'Earth Work', 'PCC Work', 'Wing Wall', 'Debris Deposition',
            'Slips', 'Boulders', 'Debris', 'Road Crust', 'Bed damaged', 'Breast Wall',
            'Slush', 'Rock Fall', 'Planks', 'Beams', 'Mulbas', 'Erosion',
            'Accumulation of boulders', 'Piles', 'activityway', 'Drain', 'PCC Berms'
        ],
        $this->module, 'category', 'Types of Damage Nature');
        return redirect()->route('admin.apps.dtms.settings.index')
            ->with('success', 'Damage Tracking System module initd with default settings and categories.');
    }

    private function initIfNeeded()
    {
        $activity = setting('activity', $this->module, null);
        if ($activity === null) {
            $this->init();
        }
    }
}
