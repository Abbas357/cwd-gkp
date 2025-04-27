<?php

namespace App\Http\Controllers\Vehicle;

use App\Models\User;
use App\Models\Vehicle;
use App\Helpers\Database;
use Illuminate\Http\Request;
use App\Helpers\SearchBuilder;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;

class VehicleController extends Controller
{
    public function all(Request $request)
    {
        $vehicles = Vehicle::query();
        
        $relationMappings = [
            'added_by' => 'user.currentPosting.designation.name',
            'assigned_to' => 'allotment.user.currentPosting.office.name',
            'officer_name' => 'allotment.user.name',
            'office_name' => 'allotment.office.name',
        ];
        
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
                    return view('modules.vehicles.partials.assignment', compact('row'))->render();
                })
                ->addColumn('officer_name', function ($row) {
                    return $row->allotment?->user?->name ?? 'Name not available';
                })
                ->addColumn('office_name', function ($row) {
                    return $row->allotment?->office?->name ?? 'Office not available';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'added_by', 'user', 'assigned_to', 'officer_name']);

            if ($request->input('search.value')) {
                Database::applyRelationalSearch($dataTable, $relationMappings);
            }

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request, $relationMappings) {
                    $sb = new SearchBuilder(
                        $request, 
                        $query,
                        [],
                        $relationMappings,
                    );
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('modules.vehicles.index');
    }

    public function create()
    {
        $cat = [
            'users' => User::all(),
            'vehicle_type' => category('vehicle_type', 'vehicle'),
            'vehicle_functional_status' => category('vehicle_functional_status', 'vehicle'),
            'vehicle_color' => category('vehicle_color', 'vehicle'),
            'fuel_type' => category('fuel_type', 'vehicle'),
            'vehicle_registration_status' => category('vehicle_registration_status', 'vehicle'),
            'vehicle_brand' => category('vehicle_brand', 'vehicle'),
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

        session(['office' => $request->office]);

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
            session()->forget('office');
            return response()->json(['success' => 'Vehicle added successfully.']);
        }

        return response()->json(['error' => 'There was an error adding the vehicle.']);
    }

    public function showDetail(Vehicle $vehicle)
    {
        $cat = [
            'users' => User::all(),
            'vehicle_type' => category('vehicle_type', 'vehicle'),
            'vehicle_functional_status' => category('vehicle_functional_status', 'vehicle'),
            'vehicle_color' => category('vehicle_color', 'vehicle'),
            'fuel_type' => category('fuel_type', 'vehicle'),
            'vehicle_registration_status' => category('vehicle_registration_status', 'vehicle'),
            'vehicle_brand' => category('vehicle_brand', 'vehicle'),
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

    public function showVehicleDetails(Vehicle $vehicle)
    {
        $allotments = $vehicle->allotments()
            ->with(['user', 'user.currentPosting', 'user.currentPosting.designation', 'user.currentPosting.office'])
            ->orderBy('start_date', 'desc')
            ->get();
            
        $currentAllotment = $allotments->where('is_current', true)->first();

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Vehicle Details',
                ],
            ]);
        }

        $html = view('modules.vehicles.partials.allotment-detail', compact('vehicle', 'allotments', 'currentAllotment'))->render();
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
