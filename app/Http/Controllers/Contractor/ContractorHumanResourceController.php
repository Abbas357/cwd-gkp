<?php

namespace App\Http\Controllers\Contractor;

use App\Models\Contractor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContractorHumanResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContractorHumanResourceController extends Controller
{
    use AuthorizesRequests;

    public function detail(Contractor $contractor)
    {
        $hr = $contractor->humanResources()->get();
        $this->authorize('detail', $hr);

        if (!$hr) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Contractor detail',
                ],
            ]);
        }
        $html = view('modules.contractors.partials.hr', compact('hr'))->render();
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
        $this->authorize('updateField', $resource);

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
        $this->authorize('uploadFile', $resource);
        
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

    public function destroy($id)
    {
        $hr = ContractorHumanResource::findOrFail($id);
        $this->authorize('delete', $hr);
        if($hr->delete()) {
            return response()->json(['success' => 'HR User deleted successfully'], 200);
        }
        return response()->json(['error' => 'Failed to delete HR User'], 500);
    }

}
