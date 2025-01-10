<?php

namespace App\Http\Controllers\Site;

use App\Models\Contractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ContractorHumanResourceController extends Controller
{
    public function create()
    {
        return view('site.contractors.hr_profile');
    }

    public function store(Request $request)
    {
        $contractor = Contractor::findOrFail(session('contractor_id'));

        $request->validate([
            'hr_profile' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'profiles.*.name' => 'required|string|max:255',
            'profiles.*.cnic_number' => 'required|string|max:15',
            'profiles.*.pec_number' => 'required|string|max:50',
            'profiles.*.designation' => 'nullable|string|max:100',
            'profiles.*.start_date' => 'nullable|date',
            'profiles.*.end_date' => 'nullable|date',
            'profiles.*.salary' => 'nullable|numeric'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->profiles as $profile) {
                $hrProfile = $contractor->humanResources()->create([
                    'name' => $profile['name'],
                    'cnic_number' => $profile['cnic_number'],
                    'pec_number' => $profile['pec_number'],
                    'designation' => $profile['designation'] ?? null,
                    'start_date' => $profile['start_date'] ?? null,
                    'end_date' => $profile['end_date'] ?? null,
                    'salary' => $profile['salary'] ?? null
                ]);

                if ($request->hasFile('hr_profile')) {
                    $hrProfile->addMedia($request->file('hr_profile'))
                        ->toMediaCollection('hr_documents');
                }
            }

            DB::commit();
            return redirect()->back()->with('status', 'HR Profiles saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while saving the profiles.'])
                ->withInput();
        }
    }
}
