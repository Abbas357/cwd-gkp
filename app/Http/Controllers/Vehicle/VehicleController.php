<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\VehicleAllotment;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreVehicleRequest;

class VehicleController extends Controller
{
    public function all(Request $request)
    {
        $vehicles = Vehicle::query();

        if ($request->ajax()) {
            $dataTable = Datatables::of($vehicles)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.vehicles.partials.buttons', compact('row'))->render();
                })
                ->addColumn('added_by', function ($row) {
                    return $row->user->currentPosting?->designation->name 
                    ? '<a href="'.route('admin.apps.hr.users.show', $row->user->id).'" target="_blank">'.$row->user->currentPosting?->designation->name .'</a>' 
                    : ($row->user->currentPosting?->designation->name  ?? 'N/A');
                })
                ->addColumn('assigned_to', function ($row) {
                    return $row->allotment->user->currentPosting->office->name ?? 'Pool';
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

        return view('modules.vehicles.index');
    }

    private function getDistribution($field)
    {
        return Vehicle::selectRaw("$field, COUNT(*) as count")
            ->whereNotNull($field)
            ->groupBy($field)
            ->orderBy('count', 'desc')
            ->get();
    }

    public function index(Request $request)
    {
        $totalVehicles = Vehicle::count();

        $functionalVehicles = Vehicle::where('functional_status', 'Functional')->count();
        $nonFunctionalVehicles = Vehicle::where('functional_status', 'Non-Functional')->count();
        $condemnedVehicles = Vehicle::where('functional_status', 'Condemned')->count();

        $allotedVehicles = VehicleAllotment::whereNot('type', 'Pool')->where('is_current', 1)->count();

        $permanentAlloted = VehicleAllotment::where('is_current', 1)
            ->where('type', 'Permanent')
            ->count();

        $temporaryAlloted = VehicleAllotment::where('is_current', 1)
            ->where('type', 'Temporary')
            ->count();

        $departmentPool = VehicleAllotment::where('is_current', 1)
            ->where('type', 'Pool')
            ->count();

        $officePool = VehicleAllotment::where('is_current', 1)
            ->where('type', 'Pool')
            ->whereNotNull('user_id')
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

        $recentAllotments = VehicleAllotment::with(['vehicle', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $vehiclesNeedingAttention = Vehicle::where('functional_status', 'Non-Functional')
            ->orWhere('functional_status', 'Condemned')
            ->with('allotment.user')
            ->take(5)
            ->get();

        $fuelTypeStats = Vehicle::selectRaw('fuel_type, COUNT(*) as count')
            ->whereNotNull('fuel_type')
            ->groupBy('fuel_type')
            ->get();

        $functionalPercentage = $totalVehicles > 0 ? ($functionalVehicles / $totalVehicles) * 100 : 0;
        $allotedPercentage = $totalVehicles > 0 ? ($allotedVehicles / $totalVehicles) * 100 : 0;
        $poolPercentage = $totalVehicles > 0 ? ($departmentPool / $totalVehicles) * 100 : 0;

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

        return view('modules.vehicles.dashboard', compact(
            'totalVehicles',
            'functionalVehicles',
            'condemnedVehicles',
            'allotedVehicles',
            'permanentAlloted',
            'temporaryAlloted',
            'departmentPool',
            'officePool',
            'monthlyAllotments',
            'distributions',
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

        $html = view('modules.vehicles.partials.create', compact('cat'))->render();
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

    public function showDetail(Vehicle $vehicle)
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

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Vehicle Detail',
                ],
            ]);
        }

        $html = view('modules.vehicles.partials.detail', compact('vehicle', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function vehicleHistory(Vehicle $vehicle)
    {
        $allotments = $vehicle->allotments;

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Vehicle History',
                ],
            ]);
        }

        $html = view('modules.vehicles.partials.history', compact('vehicle', 'allotments'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Vehicle $vehicle)
    {
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

    public function uploadFile(Request $request, Vehicle $vehicle)
    {
        $file = $request->file;
        $collection = $request->collection;
        $vehicle->addMedia($file)->toMediaCollection($collection);
        if ($vehicle->save()) {
            return response()->json(['success' => 'File Updated']);
        }
        return response()->json(['error' => 'Error Uploading File']);
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
            'allotment_status' => ['Pool', 'Permanent', 'Temparory'],
        ];

        $filters = [
            'user_id' => null,
            'vehicle_id' => null,
            'type' => null,
            'status' => null,
            'color' => null,
            'fuel_type' => null,
            'registration_status' => null,
            'brand' => null,
            'model_year' => null,
            'allotment_status' => null
        ];

        $filters = array_merge($filters, $request->only(array_keys($filters)));

        $include_subordinates = $request->boolean('include_subordinates', false);
        $show_history = $request->boolean('show_history', false);
        
        $perPage = $request->input('per_page', 10);
        $showAll = $perPage === 'all';
        
        if (!$showAll && is_string($perPage)) {
            $perPage = (int) $perPage;
        }

        $query = VehicleAllotment::query()
            ->with(['vehicle', 'user'])
            ->when(!$show_history, fn($q) => $q->whereNot('is_current', 0))
            ->when(request('allotment_status'), function($q)  {
                if (request('allotment_status') === 'Pool') {
                    return $q->where('type', 'Pool');
                } 
                else {
                    return $q->where('type', request('allotment_status'));
                }
            })
            ->when(!request('allotment_status'), function($q) {
                return $q->where('type', '!=', 'Pool');
            });

        if ($filters['user_id']) {
            if ($include_subordinates) {
                $user = User::find($filters['user_id']);
                $subordinateIds = $user->getSubordinates()->pluck('id')->toArray();
                $userIds = array_merge([$user->id], $subordinateIds);
                $query->whereIn('user_id', $userIds);
            } else {
                $query->where('user_id', $filters['user_id']);
            }
        }

        if ($filters['vehicle_id']) {
            $query->where('vehicle_id', $filters['vehicle_id']);
        }

        if ($filters['allotment_status']) {
            $query->where('type', $filters['allotment_status']);
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

            if ($filters['model_year']) {
                $q->where('model_year', $filters['model_year']);
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

        $totalCount = $query->count();
        
        if ($showAll) {
            $allotments = $query->latest()->get();
        } else {
            try {
                $allotments = $query->latest()->paginate($perPage);
                $allotments->appends($request->except('page'));
            } catch (\Exception $e) {
                $perPage = 10;
                $allotments = $query->latest()->paginate($perPage);
                $allotments->appends($request->except('page'));
            }
        }
        
        $paginationOptions = [
            10 => '10 per page',
            50 => '50 per page',
            100 => '100 per page',
            'all' => 'Show All'
        ];

        return view('modules.vehicles.reports', compact('cat', 'allotments', 'filters', 'totalCount', 'perPage', 'paginationOptions'));
    }

    public function search(Request $request)
    {
        return Vehicle::query()
            ->when($request->q, fn($q) => $q->where('registration_number', 'like', "%{$request->q}%")
                ->orWhere('engine_number', 'like', "%{$request->q}%")
                ->orWhere('chassis_number', 'like', "%{$request->q}%"))
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
