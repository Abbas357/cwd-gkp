<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use Illuminate\Http\Request;
use App\Models\ContractorHumanResource;

class ContractorHumanResourceController extends Controller
{
    public function detail(Contractor $Contractor)
    {
        $hr = $Contractor->humanResources()->get();

        if (!$hr) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Contractor detail',
                ],
            ]);
        }
        $html = view('admin.contractors.partials.hr', compact('hr'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $resource = ContractorHumanResource::findOrFail($id);

        $validatedData = $request->validate([
            'field' => 'required|string',
            'value' => 'required'
        ]);

        try {
            $resource->{$validatedData['field']} = $validatedData['value'];

            $resource->save();

            return response()->json([
                'success' => true,
                'message' => 'Resource updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update resource'
            ], 500);
        }
    }

    public function upload(Request $request, $id)
    {
        $resource = ContractorHumanResource::findOrFail($id);
        
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);
        
        try {
            $media = $resource->addMedia($request->file('file'))->toMediaCollection('contractor_hr_resumes');
            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'fileUrl' => $media->getUrl()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload file'
            ], 500);
        }
    }
}
