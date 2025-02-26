<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\VehicleAllotment;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreVehicleRequest;

class VehicleController extends Controller
{
    public function dashboard()
    {
        $totalVehicles = Vehicle::count();

        $functionalVehicles = Vehicle::where('functional_status', 'Functional')->count();
        $condemnedVehicles = Vehicle::where('functional_status', 'Condemned')->count();

        $allotedVehicles = VehicleAllotment::whereNull('end_date')->count();

        $permanentAlloted = VehicleAllotment::whereNull('end_date')
            ->where('type', 'Permanent')
            ->count();

        $temporaryAlloted = VehicleAllotment::whereNull('end_date')
            ->where('type', 'Temparory')
            ->count();

        $inPool = VehicleAllotment::whereNull('end_date')
            ->where('type', 'Pool')
            ->count();

        $monthlyAllotments = VehicleAllotment::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->limit(6)
            ->get();

        $distributions = [
            'type' => $this->getDistribution('type'),
            'color' => $this->getDistribution('color'),
            'fuel_type' => $this->getDistribution('fuel_type'),
            'registration_status' => $this->getDistribution('registration_status'),
            'brand' => $this->getDistribution('brand'),
            'model_year' => $this->getDistribution('model_year')
        ];

        $modelsByBrand = Vehicle::selectRaw('brand, model, COUNT(*) as count')
            ->whereNotNull('brand')
            ->whereNotNull('model')
            ->groupBy('brand', 'model')
            ->get()
            ->groupBy('brand');

        $recentAllotments = VehicleAllotment::with(['vehicle', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $vehiclesNeedingAttention = Vehicle::where('functional_status', 'Needs Maintenance')
            ->orWhere('functional_status', 'Under Repair')
            ->with('allotment.user')
            ->take(5)
            ->get();

        $fuelTypeStats = Vehicle::selectRaw('fuel_type, COUNT(*) as count')
            ->whereNotNull('fuel_type')
            ->groupBy('fuel_type')
            ->get();

        $functionalPercentage = $totalVehicles > 0 ? ($functionalVehicles / $totalVehicles) * 100 : 0;
        $allotedPercentage = $totalVehicles > 0 ? ($allotedVehicles / $totalVehicles) * 100 : 0;
        $poolPercentage = $totalVehicles > 0 ? ($inPool / $totalVehicles) * 100 : 0;

        $yearWiseRegistrations = Vehicle::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        $brandWiseStatus = Vehicle::selectRaw('brand, functional_status, COUNT(*) as count')
            ->whereNotNull('brand')
            ->whereNotNull('functional_status')
            ->groupBy('brand', 'functional_status')
            ->get()
            ->groupBy('brand');

        $allocationTrends = VehicleAllotment::selectRaw('
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

        return view('admin.vehicles.dashboard', compact(
            'totalVehicles',
            'functionalVehicles',
            'condemnedVehicles',
            'allotedVehicles',
            'permanentAlloted',
            'temporaryAlloted',
            'inPool',
            'monthlyAllotments',
            'distributions',
            'modelsByBrand',
            'recentAllotments',
            'vehiclesNeedingAttention',
            'fuelTypeStats',
            'functionalPercentage',
            'allotedPercentage',
            'poolPercentage',
            'yearWiseRegistrations',
            'brandWiseStatus',
            'allocationTrends'
        ));
    }

    private function getDistribution($field)
    {
        return Vehicle::selectRaw("$field, COUNT(*) as count")
            ->whereNotNull($field)
            ->groupBy($field)
            ->orderBy('count', 'desc')
            ->get();
    }

    private function formatPercentage($value, $decimals = 2)
    {
        return round($value, $decimals);
    }

    public function index(Request $request)
    {
        $vehicles = Vehicle::query();

        if ($request->ajax()) {
            $dataTable = Datatables::of($vehicles)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.vehicles.partials.buttons', compact('row'))->render();
                })
                ->addColumn('added_by', function ($row) {
                    return $row->user?->position
                        ? '<a href="' . route('admin.users.show', $row->user->id) . '" target="_blank">' . $row->user->position . '</a>'
                        : ($row->user?->designation ?? 'N/A');
                })
                ->addColumn('assigned_to', function ($row) {
                    return $row->allotment->user->position ?? 'Pool';
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

        return view('admin.vehicles.index');
    }

    public function create()
    {
        $cat = [
            'users' => User::all(),
            'vehicle_type' => Category::where('type', 'vehicle_type')->get(),
            'vehicle_functional_status' => Category::where('type', 'vehicle_functional_status')->get(),
            'vehicle_color' => Category::where('type', 'vehicle_color')->get(),
            'fuel_type' => Category::where('type', 'fuel_type')->get(),
            'vehicle_registration_status' => Category::where('type', 'vehicle_registration_status')->get(),
            'vehicle_brand' => Category::where('type', 'vehicle_brand')->get(),
        ];

        $html = view('admin.vehicles.partials.create', compact('cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreVehicleRequest $request)
    {
        $vehicle = new Vehicle();
        $vehicle->type = $request->type;
        $vehicle->functional_status = $request->functional_status;
        $vehicle->color = $request->color;
        $vehicle->registration_number = $request->registration_number;
        $vehicle->fuel_type = $request->fuel_type;
        $vehicle->brand = $request->brand;
        $vehicle->model = $request->model;
        $vehicle->model_year = $request->model_year;
        $vehicle->registration_status = $request->registration_status;
        $vehicle->chassis_number = $request->chassis_number;
        $vehicle->engine_number = $request->engine_number;
        $vehicle->user_id = $request->user()->id;
        $vehicle->remarks = $request->remarks;

        if ($request->hasFile('front_view')) {
            $vehicle->addMedia($request->file('front_view'))
                ->toMediaCollection('vehicle_front_pictures');
        }

        if ($request->hasFile('side_view')) {
            $vehicle->addMedia($request->file('side_view'))
                ->toMediaCollection('vehicle_side_pictures');
        }

        if ($request->hasFile('rear_view')) {
            $vehicle->addMedia($request->file('rear_view'))
                ->toMediaCollection('vehicle_rear_pictures');
        }

        if ($request->hasFile('interior_view')) {
            $vehicle->addMedia($request->file('interior_view'))
                ->toMediaCollection('vehicle_interior_pictures');
        }

        if ($vehicle->save()) {
            return response()->json(['success' => 'Vehicle added successfully.']);
        }

        return response()->json(['error' => 'There was an error adding the vehicle.']);
    }

    public function showDetail($id)
    {
        $cat = [
            'vehicle_type' => Category::where('type', 'vehicle_type')->get(),
            'vehicle_functional_status' => Category::where('type', 'vehicle_functional_status')->get(),
            'vehicle_color' => Category::where('type', 'vehicle_color')->get(),
            'fuel_type' => Category::where('type', 'fuel_type')->get(),
            'vehicle_registration_status' => Category::where('type', 'vehicle_registration_status')->get(),
            'vehicle_brand' => Category::where('type', 'vehicle_brand')->get(),
        ];

        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Vehicle Detail',
                ],
            ]);
        }

        $html = view('admin.vehicles.partials.detail', compact('vehicle', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function vehicleHistory($id)
    {
        $vehicle = Vehicle::find($id);
        $allotments = $vehicle->allotments;

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Vehicle History',
                ],
            ]);
        }

        $html = view('admin.vehicles.partials.history', compact('vehicle', 'allotments'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $vehicle->{$request->field} = $request->value;

        if ($vehicle->isDirty($request->field)) {
            $vehicle->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function reports(Request $request)
    {
        $cat = [
            'users' => User::all(),
            'vehicle_type' => Category::where('type', 'vehicle_type')->get(),
            'vehicle_functional_status' => Category::where('type', 'vehicle_functional_status')->get(),
            'vehicle_color' => Category::where('type', 'vehicle_color')->get(),
            'fuel_type' => Category::where('type', 'fuel_type')->get(),
            'vehicle_registration_status' => Category::where('type', 'vehicle_registration_status')->get(),
            'vehicle_brand' => Category::where('type', 'vehicle_brand')->get(),
        ];

        $filters = [
            'user_id' => null,
            'vehicle_id' => null,
            'type' => null,
            'status' => null,
            'color' => null,
            'fuel_type' => null,
            'registration_status' => null,
            'brand' => null
        ];

        $filters = array_merge($filters, $request->only(array_keys($filters)));

        $include_subordinates = $request->boolean('include_subordinates', false);
        $show_history = $request->boolean('show_history', false);

        $query = VehicleAllotment::query()
            ->with(['vehicle', 'user'])
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

        if ($filters['vehicle_id']) {
            $query->where('vehicle_id', $filters['vehicle_id']);
        }

        $query->whereHas('vehicle', function ($q) use ($filters, $cat) {
            if ($filters['status']) {
                $status = $cat['vehicle_functional_status']->firstWhere('id', $filters['status']);
                $q->where('functional_status', $status->name ?? '');
            }

            if ($filters['type']) {
                $type = $cat['vehicle_type']->firstWhere('id', $filters['type']);
                $q->where('type', $type->name ?? '');
            }

            $additionalFilters = [
                'color' => 'vehicle_color',
                'fuel_type' => 'fuel_type',
                'registration_status' => 'vehicle_registration_status',
                'brand' => 'vehicle_brand'
            ];

            foreach ($additionalFilters as $field => $categoryType) {
                if ($filters[$field]) {
                    $category = $cat[$categoryType]->firstWhere('id', $filters[$field]);
                    $q->where($field, $category->name ?? '');
                }
            }
        });

        $allotments = $query->latest()->get();

        return view('admin.vehicles.reports', compact('cat', 'allotments', 'filters'));
    }

    public function search(Request $request)
    {
        return Vehicle::query()
            ->when($request->q, fn($q) => $q->where('registration_number', 'like', "%{$request->q}%")
                ->orWhere('brand', 'like', "%{$request->q}%"))
            ->limit(10)
            ->get()
            ->map(fn($v) => ['id' => $v->id, 'text' => "{$v->brand} - {$v->model}"]);
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);
        if (request()->user()->isAdmin() && $vehicle->delete()) {
            $vehicle->allotments()->delete();
            return response()->json(['success' => 'Vehicle has been deleted successfully.']);
        }

        return response()->json(['error' => 'You are not authorized to delete the vehicle.']);
    }
}
