<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Asset;
use App\Models\AssetAllotment;
use App\Http\Requests\StoreAssetAllotmentRequest;

class AssetAllotmentController extends Controller
{
    public function create($id)
    {
        $asset = Asset::find($id);
        
        $cat = [
            'allotment_type' => ['Pool', 'Permanent','Temporary'],
            'users' => User::all(),
        ];

        if (!$asset) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Asset Detail',
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
    
    public function store(StoreAssetAllotmentRequest $request)
    {
        $allotment = new AssetAllotment();
        $allotment->type = $request->type;
        $allotment->start_date = $request->start_date;
        $allotment->end_date = $request->end_date ?: null;
        $allotment->vehicle_id = $request->vehicle_id;
        $allotment->user_id = $request->user_id;
        $allotment->office_id = $request->office_id;

        if ($request->hasFile('allotment_order')) {
            $allotment->addMedia($request->file('allotment_order'))
                ->toMediaCollection('vehicle_allotment_orders');
        }
        
        if ($allotment->save()) {
            return response()->json(['success' => 'Asset has been allotted successfully.']);
        }

        return response()->json(['error' => 'There was an error allotting the vehicle.'], 500);
    }

}
