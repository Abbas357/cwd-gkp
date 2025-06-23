<?php

namespace App\Http\Controllers\Machinery;

use App\Models\User;

use App\Models\Office;
use App\Models\Machinery;
use App\Models\MachineryAllocation;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMachineryAllocationRequest;

class MachineryAllocationController extends Controller
{
    public function create($id)
    {
        $machinery = Machinery::find($id);
        $cat = [
            'allocation_type' => ['Pool', 'Permanent','Temporary'],
            'Office' => Office::all(),
        ];
        if (!$machinery) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Machinery Detail',
                ],
            ]);
        }

        $html = view('modules.machinery.partials.allocation', compact('machinery', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }
    
    public function store(StoreMachineryAllocationRequest $request)
    {
        $allotment = new MachineryAllocation();
        $allotment->type = $request->type;
        $allotment->start_date = $request->start_date;
        $allotment->end_date = $request->end_date ?: null;
        $allotment->machinery_id = $request->machinery_id;
        $allotment->office_id = $request->office_id;

        if ($request->hasFile('machiery_allocation_orders')) {
            $allotment->addMedia($request->file('machiery_allocation_orders'))
                ->toMediaCollection('machiery_allocation_orders');
        }

        if ($allotment->save()) {
            return response()->json(['success' => 'Machinery has been allocated successfully.']);
        }

        return response()->json(['error' => 'There was an error allocating the machinery.'], 500);
    }
}
