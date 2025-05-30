<?php

namespace App\Http\Controllers\Contractor;

use App\Models\Contractor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContractorWorkExperience;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContractorWorkExperienceController extends Controller
{
    use AuthorizesRequests;

    public function detail(Contractor $contractor)
    {
        $experiences = $contractor->workExperiences()->get();
        if (!$experiences) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load experience detail',
                ],
            ]);
        }
        $html = view('modules.contractors.partials.experience', compact('experiences'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $experience = ContractorWorkExperience::findOrFail($id);
        $validatedData = $request->validate([
            'field' => 'required|string',
            'value' => 'required'
        ]);

        try {
            $experience->{$validatedData['field']} = $validatedData['value'];

            $experience->save();

            return response()->json([
                'success' => 'Resource updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 'Failed to update experience'
            ], 500);
        }
    }

    public function upload(Request $request, $id)
    {
        $experience = ContractorWorkExperience::findOrFail($id);        
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);
        
        try {
            $media = $experience->addMedia($request->file('file'))->toMediaCollection('contractor_work_orders');
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
        $experience = ContractorWorkExperience::findOrFail($id);
        if($experience->delete()) {
            return response()->json(['success' => 'Experience deleted successfully'], 200);
        }
        return response()->json(['error' => 'Failed to delete Experience'], 500);
    }
}
