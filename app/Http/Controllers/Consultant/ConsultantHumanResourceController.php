<?php

namespace App\Http\Controllers\Consultant;

use App\Models\Consultant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ConsultantHumanResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ConsultantHumanResourceController extends Controller
{
    use AuthorizesRequests;

    public function detail(Consultant $consultant)
    {
        $employees = $consultant->humanResources()->get();
        if (!$employees) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Consultant detail',
                ],
            ]);
        }
        $html = view('modules.consultants.partials.hr', compact('employees'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $resource = ConsultantHumanResource::findOrFail($id);
        $validatedData = $request->validate([
            'field' => 'required|string',
            'value' => 'required'
        ]);

        try {
            $resource->{$validatedData['field']} = $validatedData['value'];

            $resource->save();

            return response()->json([
                'success' => 'Resource updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 'Failed to update resource'
            ], 500);
        }
    }

    public function upload(Request $request, $id)
    {
        $resource = ConsultantHumanResource::findOrFail($id);
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);
        
        try {
            $media = $resource->addMedia($request->file('file'))->toMediaCollection('consultant_hr_resumes');
            return response()->json([
                'success' => 'File uploaded successfully',
                'fileUrl' => $media->getUrl()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 'Failed to upload file'
            ], 500);
        }
    }

    public function destroy($id)
    {
        $hr = ConsultantHumanResource::findOrFail($id);
        if($hr->delete()) {
            return response()->json(['success' => 'Employee deleted successfully'], 200);
        }
        return response()->json(['error' => 'Failed to delete Employee'], 500);
    }

}
