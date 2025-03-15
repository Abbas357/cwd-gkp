<?php

namespace App\Http\Controllers\Machinery;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Machinery;
use App\Models\MachineryAllocation;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreMachineryRequest;

class MachineryController extends Controller
{
    public function all(Request $request)
    {
        $machines = Machinery::query();

        if ($request->ajax()) {
            $dataTable = Datatables::of($machines)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.machinery.partials.buttons', compact('row'))->render();
                })
                ->addColumn('added_by', function ($row) {
                    return $row->user->currentPosting?->designation->name 
                    ? '<a href="'.route('admin.apps.hr.users.show', $row->user->id).'" target="_blank">'.$row->user->currentPosting?->designation->name .'</a>' 
                    : ($row->user->currentPosting?->designation->name  ?? 'N/A');
                })
                ->addColumn('assigned_to', function ($row) {
                    return $row->allocation->user->currentPosting->office->name ?? 'Pool';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'added_by', 'user']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('modules.machinery.index');
    }

    private function getDistribution($field)
    {
        return Machinery::selectRaw("$field, COUNT(*) as count")
            ->whereNotNull($field)
            ->groupBy($field)
            ->orderBy('count', 'desc')
            ->get();
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

        $recentAllocations = MachineryAllocation::with(['machinery', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $machineryNeedingAttention = Machinery::where('operational_status', 'Non-Operational')
            ->orWhere('operational_status', 'Under Maintenance')
            ->with('allocation.user')
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

        $maintenanceSchedule = Machinery::whereNotNull('next_maintenance_date')
            ->orderBy('next_maintenance_date')
            ->take(5)
            ->get();

        $operatingHoursStats = Machinery::selectRaw('
            CASE 
                WHEN operating_hours < 1000 THEN "< 1,000 hours"
                WHEN operating_hours < 5000 THEN "1,000-5,000 hours"
                WHEN operating_hours < 10000 THEN "5,000-10,000 hours"
                ELSE "> 10,000 hours"
            END as hour_range,
            COUNT(*) as count
        ')
            ->whereNotNull('operating_hours')
            ->groupBy('hour_range')
            ->get();

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
            'maintenanceSchedule',
            'operatingHoursStats'
        ));
    }

    public function create()
    {
        $cat = [
            'users' => User::all(),
            'machinery_type' => Category::where('type', 'machinery_type')->get(),
            'machinery_operational_status' => Category::where('type', 'machinery_operational_status')->get(),
            'machinery_power_source' => Category::where('type', 'machinery_power_source')->get(),
            'machinery_location' => Category::where('type', 'machinery_location')->get(),
            'machinery_manufacturer' => Category::where('type', 'machinery_manufacturer')->get(),
            'machinery_certification_status' => Category::where('type', 'machinery_certification_status')->get(),
        ];

        $html = view('modules.machinery.partials.create', compact('cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreMachineryRequest $request)
    {
        $machinery = new Machinery();
        $machinery->type = $request->type;
        $machinery->operational_status = $request->operational_status;
        $machinery->manufacturer = $request->manufacturer;
        $machinery->model = $request->model;
        $machinery->serial_number = $request->serial_number;
        $machinery->power_source = $request->power_source;
        $machinery->power_rating = $request->power_rating;
        $machinery->manufacturing_year = $request->manufacturing_year;
        $machinery->operating_hours = $request->operating_hours;
        $machinery->last_maintenance_date = $request->last_maintenance_date;
        $machinery->next_maintenance_date = $request->next_maintenance_date;
        $machinery->location = $request->location;
        $machinery->hourly_cost = $request->hourly_cost;
        $machinery->asset_tag = $request->asset_tag;
        $machinery->certification_status = $request->certification_status;
        $machinery->specifications = $request->specifications;
        $machinery->user_id = $request->user()->id;
        $machinery->remarks = $request->remarks;

        if ($request->hasFile('front_view')) {
            $machinery->addMedia($request->file('front_view'))
                ->toMediaCollection('machinery_front_pictures');
        }

        if ($request->hasFile('side_view')) {
            $machinery->addMedia($request->file('side_view'))
                ->toMediaCollection('machinery_side_pictures');
        }

        if ($request->hasFile('control_panel')) {
            $machinery->addMedia($request->file('control_panel'))
                ->toMediaCollection('machinery_control_panel_pictures');
        }

        if ($request->hasFile('specification_plate')) {
            $machinery->addMedia($request->file('specification_plate'))
                ->toMediaCollection('machinery_specification_plate_pictures');
        }

        if ($machinery->save()) {
            return response()->json(['success' => 'Machinery added successfully.']);
        }

        return response()->json(['error' => 'There was an error adding the machinery.']);
    }

    public function showDetail(Machinery $machinery)
    {
        $cat = [
            'machinery_type' => Category::where('type', 'machinery_type')->get(),
            'machinery_operational_status' => Category::where('type', 'machinery_operational_status')->get(),
            'machinery_power_source' => Category::where('type', 'machinery_power_source')->get(),
            'machinery_location' => Category::where('type', 'machinery_location')->get(),
            'machinery_manufacturer' => Category::where('type', 'machinery_manufacturer')->get(),
            'machinery_certification_status' => Category::where('type', 'machinery_certification_status')->get(),
        ];

        if (!$machinery) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Machinery Detail',
                ],
            ]);
        }

        $html = view('modules.machinery.partials.detail', compact('machinery', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function machineryHistory(Machinery $machinery)
    {
        $allocations = $machinery->allocations;

        if (!$machinery) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Machinery History',
                ],
            ]);
        }

        $html = view('modules.machinery.partials.history', compact('machinery', 'allocations'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Machinery $machinery)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $machinery->{$request->field} = $request->value;

        if ($machinery->isDirty($request->field)) {
            $machinery->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function updateMaintenanceInfo(Request $request, Machinery $machinery)
    {
        $request->validate([
            'operating_hours' => 'required|numeric',
            'last_maintenance_date' => 'nullable|date',
            'next_maintenance_date' => 'nullable|date',
            'maintenance_notes' => 'nullable|string',
        ]);

        $machinery->operating_hours = $request->operating_hours;
        $machinery->last_maintenance_date = $request->last_maintenance_date;
        $machinery->next_maintenance_date = $request->next_maintenance_date;
        
        if ($request->has('maintenance_notes')) {
            $machinery->remarks = $machinery->remarks . "\n\nMaintenance (" . now()->format('Y-m-d') . "): " . $request->maintenance_notes;
        }

        if ($machinery->save()) {
            return response()->json(['success' => 'Maintenance information updated successfully'], 200);
        }

        return response()->json(['error' => 'Failed to update maintenance information'], 500);
    }

    public function reports(Request $request)
    {
        $cat = [
            'users' => User::all(),
            'machinery_type' => Category::where('type', 'machinery_type')->get(),
            'machinery_operational_status' => Category::where('type', 'machinery_operational_status')->get(),
            'machinery_power_source' => Category::where('type', 'machinery_power_source')->get(),
            'machinery_location' => Category::where('type', 'machinery_location')->get(),
            'machinery_manufacturer' => Category::where('type', 'machinery_manufacturer')->get(),
            'machinery_certification_status' => Category::where('type', 'machinery_certification_status')->get(),
        ];

        $filters = [
            'user_id' => null,
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

        if ($filters['user_id']) {
            if ($include_subordinates) {
                $user = User::find($filters['user_id']);
                $subordinates = $user->getAllSubordinates()->pluck('id')->push($user->id);
                $query->whereIn('user_id', $subordinates);
            } else {
                $query->where('user_id', $filters['user_id']);
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

    public function maintenanceDue(Request $request)
    {
        $daysAhead = $request->input('days_ahead', 30);
        
        $dueMachinery = Machinery::whereNotNull('next_maintenance_date')
            ->where('next_maintenance_date', '<=', now()->addDays($daysAhead))
            ->orderBy('next_maintenance_date')
            ->get();
            
        return view('modules.machinery.maintenance-due', compact('dueMachinery', 'daysAhead'));
    }

    public function search(Request $request)
    {
        return Machinery::query()
            ->when($request->q, fn($q) => $q->where('asset_tag', 'like', "%{$request->q}%")
                ->orWhere('manufacturer', 'like', "%{$request->q}%")
                ->orWhere('model', 'like', "%{$request->q}%")
                ->orWhere('serial_number', 'like', "%{$request->q}%"))
            ->limit(10)
            ->get()
            ->map(fn($m) => ['id' => $m->id, 'text' => "{$m->manufacturer} - {$m->model} ({$m->asset_tag})"]);
    }

    public function destroy($id)
    {
        $machinery = Machinery::find($id);
        if (request()->user()->isAdmin() && $machinery->delete()) {
            $machinery->allocations()->delete();
            return response()->json(['success' => 'Machinery has been deleted successfully.']);
        }

        return response()->json(['error' => 'You are not authorized to delete the machinery.']);
    }
}