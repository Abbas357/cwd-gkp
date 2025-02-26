<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;

use App\Models\Contractor;
use Illuminate\Http\Request;
use App\Models\ContractorMachinery;

class ContractorMachineryController extends Controller
{
    public function detail(Contractor $Contractor)
    {
        $machinery = $Contractor->machinery()->get();

        if (!$machinery) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load machinery detail',
                ],
            ]);
        }
        $html = view('modules.contractors.partials.machinery', compact('machinery'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $machine = ContractorMachinery::findOrFail($id);

        $validatedData = $request->validate([
            'field' => 'required|string',
            'value' => 'required'
        ]);

        try {
            $machine->{$validatedData['field']} = $validatedData['value'];

            $machine->save();

            return response()->json([
                'success' => true,
                'message' => 'Machinery updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update machinery'
            ], 500);
        }
    }

    public function upload(Request $request, $id)
    {
        $machine = ContractorMachinery::findOrFail($id);

        $request->validate([
            'file' => 'required|file|max:10240',
            'collection' => 'string',
        ]);

        try {
            $media = $machine->addMedia($request->file('file'))
                ->toMediaCollection($request->collection);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'fileUrl' => $media->getUrl(),
                'fileId' => $media->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload file: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $machine = ContractorMachinery::findOrFail($id);
        if($machine->delete()) {
            return response()->json(['success' => 'Machinery deleted successfully'], 200);
        }
        return response()->json(['error' => 'Failed to delete machinery'], 500);
    }
}
