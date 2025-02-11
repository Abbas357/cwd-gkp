<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleAllotment;
use App\Models\VehicleUser;
use App\Http\Requests\StoreVehicleAllotmentRequest;

class VehicleAllotmentController extends Controller
{
    public function create($id)
    {
        $vehicle = Vehicle::find($id);
        
        $cat = [
            'allotment_type' => ['Pool','Temporary','Permanent'],
            'office_type' => ['Division','Sub Division','Executive Office', 'Secretariat', 'Circle', 'Others'],
            'vehicleUsers' => VehicleUser::all(),
        ];

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Vehicle Detail',
                ],
            ]);
        }

        $html = view('admin.vehicles.partials.allotment', compact('vehicle', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }
    
    public function store(StoreVehicleAllotmentRequest $request)
    {
        $allotment = new VehicleAllotment();
        $allotment->type = $request->type;
        $allotment->date = $request->date;
        $allotment->alloted_to = $request->alloted_to;
        $allotment->vehicle_id = $request->vehicle_id;
        $allotment->office_type = $request->office_type;
        $allotment->user_id = request()->user()->id;

        if ($allotment->save()) {
            return response()->json(['success' => 'Vehicle has been alloted successfully.']);
        }

        return response()->json(['error' => 'There was an error alloting the vehicle.'], 500);
    }

    public function delete($id)
    {
        $allotment = VehicleAllotment::findOrFail($id);

        if ($allotment->delete()) {
            return redirect()->back()->with('success', 'Allotment deleted successfully');
        }

        return redirect()->back()->with('error', 'Allotment cannot be deleted');
    }


}
