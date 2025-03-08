<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleUser;
use App\Models\VehicleAllotment;
use App\Http\Requests\StoreVehicleAllotmentRequest;

class VehicleAllotmentController extends Controller
{
    public function create($id)
    {
        $vehicle = Vehicle::find($id);
        
        $cat = [
            'allotment_type' => ['Pool', 'Permanent','Temporary'],
            'users' => User::all(),
        ];

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Vehicle Detail',
                ],
            ]);
        }

        $html = view('modules.vehicles.partials.allotment', compact('vehicle', 'cat'))->render();
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
        $allotment->start_date = $request->start_date;
        $allotment->end_date = $request->end_date ?: null;
        $allotment->vehicle_id = $request->vehicle_id;
        $allotment->user_id = $request->user_id;

        if ($request->hasFile('allotment_order')) {
            $allotment->addMedia($request->file('allotment_order'))
                ->toMediaCollection('vehicle_allotment_orders');
        }
        
        if ($allotment->save()) {
            return response()->json(['success' => 'Vehicle has been allotted successfully.']);
        }

        return response()->json(['error' => 'There was an error allotting the vehicle.'], 500);
    }

}
