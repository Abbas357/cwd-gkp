<?php

namespace App\Http\Controllers\Site;

use App\Models\Contractor;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ContractorWorkExperienceController extends Controller
{
    public function create()
    {
        return view('site.contractors.work_experience');
    }

    public function store(Request $request)
    {
        $contractor = Contractor::findOrFail(session('contractor_id'));

        $request->validate([
            'experience_docs' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'experiences.*.adp_number' => 'required|string|max:50',
            'experiences.*.project_name' => 'required|string|max:255',
            'experiences.*.project_cost' => 'required|numeric',
            'experiences.*.commencement_date' => 'required|date',
            'experiences.*.completion_date' => 'required|date',
            'experiences.*.status' => 'nullable|in:completed,ongoing',
            'experiences.*.work_order' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->experiences as $experience) {
                $workExperience = $contractor->workExperiences()->create([
                    'adp_number' => $experience['adp_number'],
                    'project_name' => $experience['project_name'],
                    'project_cost' => $experience['project_cost'],
                    'commencement_date' => $experience['commencement_date'],
                    'completion_date' => $experience['completion_date'],
                    'status' => $experience['status'] ?? null
                ]);

                if ($request->hasFile('experience_docs')) {
                    $workExperience->addMedia($request->file('experience_docs'))
                        ->toMediaCollection('experience_documents');
                }

                if (isset($experience['work_order']) && $experience['work_order'] instanceof UploadedFile) {
                    $workExperience->addMedia($experience['work_order'])
                        ->toMediaCollection('work_orders');
                }
            }

            DB::commit();
            return redirect()->back()->with('status', 'Work experience saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while saving the work experience.'])
                ->withInput();
        }
    }
}
