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

    public function reports(Request $request)
    {
        $cat = [
            'offices' => Office::all(),
            'machinery_types' => category('type', 'machinery'),
            'machinery_brands' => category('brand', 'machinery'),
            'machinery_models' => category('model', 'machinery'),
            'statuses' => ['functional', 'condemned', 'repairable', 'under_maintenance'],
            'fuel_types' => ['diesel', 'petrol', 'electric', 'hybrid', 'other'],
        ];

        $filters = [
            'office_id' => null,
            'machinery_id' => null,
            'type' => null,
            'functional_status' => null,
            'brand' => null,
            'model' => null,
            'registration_number' => null,
            'engine_number' => null,
            'chassis_number' => null,
        ];

        $filters = array_merge($filters, $request->only(array_keys($filters)));

        $include_subordinates = $request->boolean('include_subordinates', false);
        $show_history = $request->boolean('show_history', false);

        $perPage = $request->input('per_page', 10);
        $showAll = $perPage === 'all';

        if (!$showAll && is_string($perPage)) {
            $perPage = (int) $perPage;
        }

        $query = MachineryAllocation::query()
            ->with(['machinery', 'office'])
            ->when(!$show_history, fn($q) => $q->whereNull('end_date'));
            // ->when(request('allocation_status'), function ($q) {
            //     $status = request('allocation_status');

            //     return match ($status) {
            //         'Office Pool' => $q->whereNotNull('office_id')->where('type', 'Pool'),
            //         'Department Pool' => $q->whereNull('office_id')->where('type', 'Pool'),
            //         'Active Allocation' => $q->whereNotNull('office_id')->where('type', '!=', 'Pool'),
            //         default => $q,
            //     };
            // });
        // dd($show_history);
        
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

        $query->whereHas('machinery', function ($q) use ($filters) {
            if ($filters['functional_status']) {
                $q->where('functional_status', $filters['functional_status']);
            }

            if ($filters['type']) {
                $q->where('type', $filters['type']);
            }

            if ($filters['brand']) {
                $q->where('brand', $filters['brand']);
            }

            if ($filters['model']) {
                $q->where('model', $filters['model']);
            }

            if ($filters['registration_number']) {
                $q->where('registration_number', 'LIKE', '%' . $filters['registration_number'] . '%');
            }

            if ($filters['engine_number']) {
                $q->where('engine_number', 'LIKE', '%' . $filters['engine_number'] . '%');
            }

            if ($filters['chassis_number']) {
                $q->where('chassis_number', 'LIKE', '%' . $filters['chassis_number'] . '%');
            }
        });

        $totalCount = $query->count();

        if ($showAll) {
            $allocations = $query->latest()->get();
        } else {
            try {
                $allocations = $query->latest()->paginate($perPage);
                $allocations->appends($request->except('page'));
            } catch (\Exception $e) {
                $perPage = 10;
                $allocations = $query->latest()->paginate($perPage);
                $allocations->appends($request->except('page'));
            }
        }

        $paginationOptions = [
            10 => '10 per page',
            25 => '25 per page',
            50 => '50 per page',
            100 => '100 per page',
            'all' => 'Show All'
        ];

        return view('modules.machinery.reports', compact('cat', 'allocations', 'filters', 'totalCount', 'perPage', 'paginationOptions'));
    }

    public function index(Request $request)
    {
        $totalMachinery = Machinery::count();

        $operationalMachinery = Machinery::where('functional_status', 'Operational')->count();
        $nonOperationalMachinery = Machinery::where('functional_status', 'Non-Operational')->count();
        $underMaintenanceMachinery = Machinery::where('functional_status', 'Under Maintenance')->count();

        $allocatedMachinery = MachineryAllocation::whereNull('end_date')->count();

        $permanentAllocated = MachineryAllocation::whereNull('end_date')
            ->where('type', 'Permanent')
            ->count();

        $temporaryAllocated = MachineryAllocation::whereNull('end_date')
            ->where('type', 'Temporary')
            ->count();

        $inStorage = MachineryAllocation::whereNull('end_date')
            ->where('type', 'Storage')
            ->count();

        $monthlyAllocations = MachineryAllocation::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->limit(6)
            ->get();

        $distributions = [
            'type' => $this->getDistribution('type'),
            'registration_number' => $this->getDistribution('registration_number'),
            'brand' => $this->getDistribution('brand'),
            'model_year' => $this->getDistribution('model_year'),
            'chassis_number' => $this->getDistribution('chassis_number')
        ];

        $modelsByManufacturer = Machinery::selectRaw('brand, model, COUNT(*) as count')
            ->whereNotNull('brand')
            ->whereNotNull('model')
            ->groupBy('brand', 'model')
            ->get()
            ->groupBy('brand');

        $recentAllocations = MachineryAllocation::with(['machinery', 'office'])
            ->latest()
            ->take(5)
            ->get();

        $machineryNeedingAttention = Machinery::where('functional_status', 'Non-Operational')
            ->orWhere('functional_status', 'Under Maintenance')
            ->with('allocation.office')
            ->take(5)
            ->get();

        $powerSourceStats = Machinery::selectRaw('registration_number, COUNT(*) as count')
            ->whereNotNull('registration_number')
            ->groupBy('registration_number')
            ->get();

        $operationalPercentage = $totalMachinery > 0 ? ($operationalMachinery / $totalMachinery) * 100 : 0;
        $allocatedPercentage = $totalMachinery > 0 ? ($allocatedMachinery / $totalMachinery) * 100 : 0;
        $storagePercentage = $totalMachinery > 0 ? ($inStorage / $totalMachinery) * 100 : 0;

        $yearWiseAcquisitions = Machinery::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        $manufacturerWiseStatus = Machinery::selectRaw('brand, functional_status, COUNT(*) as count')
            ->whereNotNull('brand')
            ->whereNotNull('functional_status')
            ->groupBy('brand', 'functional_status')
            ->get()
            ->groupBy('brand');

        $allocationTrends = MachineryAllocation::selectRaw('
            YEAR(created_at) as year, 
            MONTH(created_at) as month,
            type,
            COUNT(*) as count
        ')
            ->whereYear('created_at', '>=', now()->subYear())
            ->groupBy('year', 'month', 'type')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->groupBy('type');

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

        Setting::set('type', [
            'Excavator',
            'Bulldozer',
            'Crane',
            'Loader',
            'Grader',
            'Backhoe',
            'Compactor',
            'Forklift',
            'Paver',
            'Scraper'
        ], $this->module, 'category', 'Machine Type');

        Setting::set('brand', [
            'Caterpillar',
            'Komatsu',
            'Hitachi',
            'Volvo',
            'Liebherr',
            'John Deere',
            'Doosan',
            'Hyundai',
            'JCB',
            'Case'
        ], $this->module, 'category', 'Name of brand of the machine');

        Setting::set('model', [
            '1000cc',
            '2000cc',
            '3000cc',
            '4000cc',
            '5000cc'
        ], $this->module, 'category', 'Machine Model');

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
