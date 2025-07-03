<?php

namespace App\Http\Controllers\Dmis;

use App\Models\Damage;
use App\Models\Setting;
use App\Models\District;
use Illuminate\Http\Request;
use App\Models\Infrastructure;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $module = 'dmis';

    public function index() {
        return view('modules.dmis.home.index');
    }
    
    public function dashboard(Request $request)
    {
        $type = $request->get('type', 'Road');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        
        // Build base query with date filtering
        $baseQuery = function($query) use ($type, $fromDate, $toDate) {
            $query->where('type', $type);
            
            if ($fromDate) {
                $query->whereDate('report_date', '>=', $fromDate);
            }
            
            if ($toDate) {
                $query->whereDate('report_date', '<=', $toDate);
            }
        };
        
        // Total infrastructure (not filtered by date as it's structural data)
        $totalInfrastructure = Infrastructure::where('type', $type)->count();
        
        // Damage statistics with date filtering
        $totalDamages = Damage::where($baseQuery)->count();
        
        $fullyDamaged = Damage::where($baseQuery)
            ->where('damage_status', 'Fully Damaged')
            ->count();
        
        $partiallyDamaged = Damage::where($baseQuery)
            ->where('damage_status', 'Partially Damaged')
            ->count();
        
        $fullyRestored = Damage::where($baseQuery)
            ->where('road_status', 'Fully restored')
            ->count();
        
        $partiallyRestored = Damage::where($baseQuery)
            ->where('road_status', 'Partially restored')
            ->count();
        
        $notRestored = Damage::where($baseQuery)
            ->where('road_status', 'Not restored')
            ->count();
        
        $totalRestorationCost = Damage::where($baseQuery)
            ->sum('approximate_restoration_cost');
        
        $totalRehabilitationCost = Damage::where($baseQuery)
            ->sum('approximate_rehabilitation_cost');
        
        // Districts with stats
        $districtsWithStats = District::withCount([
            'infrastructures as infrastructure_count' => function($query) use ($type) {
                $query->where('type', $type);
            }
        ])
        ->with(['infrastructures' => function($query) use ($type) {
            $query->where('type', $type);
        }])
        ->get();
        
        foreach ($districtsWithStats as $district) {
            $infrastructureIds = $district->infrastructures->pluck('id')->toArray();
            
            // Apply date filtering to district damage counts
            $districtDamageQuery = function($query) use ($type, $fromDate, $toDate, $infrastructureIds) {
                $query->where('type', $type)
                      ->whereIn('infrastructure_id', $infrastructureIds);
                
                if ($fromDate) {
                    $query->whereDate('report_date', '>=', $fromDate);
                }
                
                if ($toDate) {
                    $query->whereDate('report_date', '<=', $toDate);
                }
            };
            
            $district->damage_count = Damage::where($districtDamageQuery)->count();
            
            $district->damaged_length = Damage::where($districtDamageQuery)
                ->sum('damaged_length');
            
            $district->restoration_cost = Damage::where($districtDamageQuery)
                ->sum('approximate_restoration_cost');
            
            $district->rehabilitation_cost = Damage::where($districtDamageQuery)
                ->sum('approximate_rehabilitation_cost');
            
            $district->fully_restored = Damage::where($districtDamageQuery)
                ->where('road_status', 'Fully restored')
                ->count();
                
            $district->partially_restored = Damage::where($districtDamageQuery)
                ->where('road_status', 'Partially restored')
                ->count();
                
            $district->not_restored = Damage::where($districtDamageQuery)
                ->where('road_status', 'Not restored')
                ->count();
        }
        
        $districtsWithStats = $districtsWithStats->sortByDesc('damage_count');
        
        // Recent damages with date filtering
        $recentDamagesQuery = Damage::with(['infrastructure', 'posting.user', 'district'])
            ->where($baseQuery)
            ->latest();
        
        $recentDamages = $recentDamagesQuery->take(5)->get();
        
        $mostAffectedDistricts = $districtsWithStats->take(5);
        
        $highestRestorationCostDistricts = $districtsWithStats->sortByDesc('restoration_cost')->take(5);
        
        // Monthly damages with date filtering
        $damagesByMonthQuery = Damage::where('type', $type);
        
        if ($fromDate) {
            $damagesByMonthQuery->whereDate('report_date', '>=', $fromDate);
        }
        
        if ($toDate) {
            $damagesByMonthQuery->whereDate('report_date', '<=', $toDate);
        }
        
        $damagesByMonth = $damagesByMonthQuery
            ->select(DB::raw('MONTH(report_date) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Prepare monthly data
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
        
        // Render the dashboard view
        $html = view('modules.dmis.home.partials.dashboard', compact(
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
            'fromDate',
            'toDate'
        ))->render();
    
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
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

        return view('modules.dmis.home.settings', compact('activityTypes', 'years'));
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

        return redirect()->route('admin.apps.dmis.settings.index')
            ->with('success', 'dmis settings updated successfully.');
    }

    public function init()
    {
        Setting::set('activity', 'Monsoon', $this->module);
        Setting::set('session', date('Y'), $this->module);
        
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
        return redirect()->route('admin.apps.dmis.settings.index')
            ->with('success', 'Damage Tracking System module initiated with default settings and categories.');
    }

    private function initIfNeeded()
    {
        $activity = setting('activity', $this->module, null);
        if ($activity === null) {
            $this->init();
        }
    }
}
