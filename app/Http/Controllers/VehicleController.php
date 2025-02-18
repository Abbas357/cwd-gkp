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
                    ? '<a href="'.route('admin.users.show', $row->user->id).'" target="_blank">'.$row->user->position.'</a>' 
                    : ($row->user?->designation ?? 'N/A');
                })
                ->addColumn('assigned_to', function ($row) {
                    return $row->allotment->user->position ?? 'N/A';
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
        
        return view('admin.vehicles.create', compact('cat'));
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

        $images = $request->file('images');

        if ($images) {
            foreach ($images as $image) {
                $vehicle->addMedia($image)->toMediaCollection('vehicle_pictures');
            }
        }

        if ($vehicle->save()) {
            return redirect()->route('admin.vehicles.index')
                ->with('success', 'Vehicle added successfully');
        }

        return redirect()->route('admin.vehicles.create')
            ->with('danger', 'There was an error adding the vehicle');
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

        $query->whereHas('vehicle', function($q) use ($filters, $cat) {
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
        ->map(fn($v) => ['id' => $v->id, 'text' => "{$v->registration_number} - {$v->brand}"]);
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);
        if (request()->user()->isAdmin() && $vehicle->delete()) {
            return response()->json(['success' => 'Vehicle has been deleted successfully.']);
        }

        return response()->json(['error' => 'You are not authorized to delete the vehicle.']);
    }
}
