<?php

namespace App\Http\Controllers\Machinery;

use App\Models\Damage;
use App\Models\Office;
use App\Models\Setting;
use App\Models\District;
use App\Models\Machinery;
use Illuminate\Http\Request;
use App\Models\Infrastructure;
use Illuminate\Support\Facades\DB;
use App\Models\MachineryAllocation;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $module = 'machinery';

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
        return view('modules.machinery.home.dashboard', compact(
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

    public function reports(Request $request)
    {
        $cat = [
            'machinery_type' => category('machinery_type', 'machinery'),
            'machinery_operational_status' => category('machinery_operational_status', 'machinery'),
            'machinery_power_source' => category('machinery_power_source', 'machinery'),
            'machinery_location' => category('machinery_location', 'machinery'),
            'machinery_manufacturer' => category('machinery_manufacturer', 'machinery'),
            'machinery_certification_status' => category('machinery_certification_status', 'machinery'),
        ];

        $filters = [
            'office_id' => null,
            'machinery_id' => null,
            'type' => null,
            'operational_status' => null,
            'power_source' => null,
            'location' => null,
            'manufacturer' => null,
            'certification_status' => null
        ];

        $filters = array_merge($filters, $request->only(array_keys($filters)));

        $include_subordinates = $request->boolean('include_subordinates', false);
        $show_history = $request->boolean('show_history', false);

        $query = MachineryAllocation::query()
            ->with(['machinery', 'user'])
            ->when(!$show_history, fn($q) => $q->whereNull('end_date'));

        if ($filters['office_id']) {
            if ($include_subordinates) {
                $office = Office::find($filters['office_id']);
                $subordinates = $office->getAllDescendants()->pluck('id')->push($office->id);
                $query->whereIn('office_id', $subordinates);
            } else {
                $query->where('office_id', $filters['office_id']);
            }
        }

        if ($filters['machinery_id']) {
            $query->where('machinery_id', $filters['machinery_id']);
        }

        $query->whereHas('machinery', function ($q) use ($filters, $cat) {
            if ($filters['operational_status']) {
                $status = $cat['machinery_operational_status']->firstWhere('id', $filters['operational_status']);
                $q->where('operational_status', $status->name ?? '');
            }

            if ($filters['type']) {
                $type = $cat['machinery_type']->firstWhere('id', $filters['type']);
                $q->where('type', $type->name ?? '');
            }

            $additionalFilters = [
                'power_source' => 'power_source',
                'location' => 'machinery_location',
                'manufacturer' => 'machinery_manufacturer',
                'certification_status' => 'certification_status'
            ];

            foreach ($additionalFilters as $field => $categoryType) {
                if ($filters[$field]) {
                    $category = $cat[$categoryType]->firstWhere('id', $filters[$field]);
                    $q->where($field, $category->name ?? '');
                }
            }
        });

        $allocations = $query->latest()->get();

        return view('modules.machinery.reports', compact('cat', 'allocations', 'filters'));
    }

    public function index(Request $request)
    {
        $totalMachinery = Machinery::count();

        $operationalMachinery = Machinery::where('operational_status', 'Operational')->count();
        $nonOperationalMachinery = Machinery::where('operational_status', 'Non-Operational')->count();
        $underMaintenanceMachinery = Machinery::where('operational_status', 'Under Maintenance')->count();

        $allocatedMachinery = MachineryAllocation::whereNull('end_date')->count();

        $permanentAllocated = MachineryAllocation::whereNull('end_date')
            ->where('purpose', 'Permanent')
            ->count();

        $temporaryAllocated = MachineryAllocation::whereNull('end_date')
            ->where('purpose', 'Temporary')
            ->count();

        $inStorage = MachineryAllocation::whereNull('end_date')
            ->where('purpose', 'Storage')
            ->count();

        $monthlyAllocations = MachineryAllocation::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->limit(6)
            ->get();

        $distributions = [
            'type' => $this->getDistribution('type'),
            'power_source' => $this->getDistribution('power_source'),
            'manufacturer' => $this->getDistribution('manufacturer'),
            'manufacturing_year' => $this->getDistribution('manufacturing_year'),
            'location' => $this->getDistribution('location'),
            'certification_status' => $this->getDistribution('certification_status')
        ];

        $modelsByManufacturer = Machinery::selectRaw('manufacturer, model, COUNT(*) as count')
            ->whereNotNull('manufacturer')
            ->whereNotNull('model')
            ->groupBy('manufacturer', 'model')
            ->get()
            ->groupBy('manufacturer');

        $recentAllocations = MachineryAllocation::with(['machinery', 'office'])
            ->latest()
            ->take(5)
            ->get();

        $machineryNeedingAttention = Machinery::where('operational_status', 'Non-Operational')
            ->orWhere('operational_status', 'Under Maintenance')
            ->with('allocation.office')
            ->take(5)
            ->get();

        $powerSourceStats = Machinery::selectRaw('power_source, COUNT(*) as count')
            ->whereNotNull('power_source')
            ->groupBy('power_source')
            ->get();

        $operationalPercentage = $totalMachinery > 0 ? ($operationalMachinery / $totalMachinery) * 100 : 0;
        $allocatedPercentage = $totalMachinery > 0 ? ($allocatedMachinery / $totalMachinery) * 100 : 0;
        $storagePercentage = $totalMachinery > 0 ? ($inStorage / $totalMachinery) * 100 : 0;

        $yearWiseAcquisitions = Machinery::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        $manufacturerWiseStatus = Machinery::selectRaw('manufacturer, operational_status, COUNT(*) as count')
            ->whereNotNull('manufacturer')
            ->whereNotNull('operational_status')
            ->groupBy('manufacturer', 'operational_status')
            ->get()
            ->groupBy('manufacturer');

        $allocationTrends = MachineryAllocation::selectRaw('
            YEAR(created_at) as year, 
            MONTH(created_at) as month,
            purpose,
            COUNT(*) as count
        ')
            ->whereYear('created_at', '>=', now()->subYear())
            ->groupBy('year', 'month', 'purpose')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->groupBy('purpose');

        return view('modules.machinery.dashboard', compact(
            'totalMachinery',
            'operationalMachinery',
            'nonOperationalMachinery',
            'underMaintenanceMachinery',
            'allocatedMachinery',
            'permanentAllocated',
            'temporaryAllocated',
            'inStorage',
            'monthlyAllocations',
            'distributions',
            'modelsByManufacturer',
            'recentAllocations',
            'machineryNeedingAttention',
            'powerSourceStats',
            'operationalPercentage',
            'allocatedPercentage',
            'storagePercentage',
            'yearWiseAcquisitions',
            'manufacturerWiseStatus',
            'allocationTrends',
        ));
    }

    private function getDistribution($field)
    {
        return Machinery::selectRaw("$field, COUNT(*) as count")
            ->whereNotNull($field)
            ->groupBy($field)
            ->orderBy('count', 'desc')
            ->get();
    }

    public function settings()
    {
        $this->initIfNeeded();
        return view('modules.machinery.settings');
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

        return redirect()->route('admin.apps.machineries.settings.index')
            ->with('success', 'Machinery settings updated successfully.');
    }

    public function init()
    {
        Setting::set('appName', 'Machinery Management System', $this->module);

        Setting::set('machinery_purpose', [
            'Pool', 'Construction', 'Building Dismantling', 'Road Dismantling', 'Building Repair', 'Other'
        ], $this->module, 'category', 'Machine Purpose and Objective');

        Setting::set('machinery_type', [
            'Excavator', 'Bulldozer', 'Crane', 'Loader', 'Grader', 
            'Backhoe', 'Compactor', 'Forklift', 'Paver', 'Scraper'
        ], $this->module, 'category', 'Machine Type');

        Setting::set('machinery_operational_status', [
            'Operational', 'Under Maintenance', 'Out of Service', 'In Storage', 'Decommissioned', 
            'Awaiting Parts', 'Under Repair', 'Retired', 'In Transit', 'Available for Use'
        ], $this->module, 'category', 'Machine Operational Status and Working Condition');

        Setting::set('machinery_power_source', [
            'Diesel', 'Electric', 'Gasoline', 'Hybrid', 'Hydraulic', 
            'Solar', 'Steam', 'Compressed Air', 'Manual', 'Natural Gas'
        ], $this->module, 'category', 'Machine Power Source');

        Setting::set('machinery_location', [
            'Repair Facility', 'Storage Yard', 'Headquarters', 'Remote Site', 'On Route', 'Deployed Location'
        ], $this->module, 'category', 'Machine location where it is place now');

        Setting::set('machinery_manufacturer', [
            'Caterpillar', 'Komatsu', 'Hitachi', 'Volvo', 'Liebherr', 
            'John Deere', 'Doosan', 'Hyundai', 'JCB', 'Case'
        ], $this->module, 'category', 'Name of manufacturer of the machine');

        Setting::set('machinery_certification_status', [
            'Certified', 'Pending Certification', 'Expired Certification', 'Not Certified', 'Under Review', 
            'Provisional Certification', 'Re-certified', 'Certification Revoked', 'Certification In Progress', 'Certification Not Required'
        ], $this->module, 'category', 'Machine Certification Status');

        return redirect()->route('admin.apps.machineries.settings.index')
            ->with('success', 'Machinery Management System module initiated with default settings and categories.');
    }

    private function initIfNeeded()
    {
        $appName = setting('appName', $this->module, null);
        if ($appName === null) {
            $this->init();
        }
    }
}
