<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContractorHumanResource;
use App\Rules\UniqueDateRangeValidation;

class ContractorHumanResourceController extends Controller
{
    public function create()
    {
        $humanResources = ContractorHumanResource::where('contractor_id', session('contractor_id'))->paginate(10);
        return view('site.contractors.hr_profile', compact('humanResources'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', 
                new UniqueDateRangeValidation('email', $request->input('start_date'), $request->input('end_date'))],
            'mobile_number' => ['required', 'string', 'max:255', 
                new UniqueDateRangeValidation('mobile_number', $request->input('start_date'), $request->input('end_date'))],
            'cnic_number' => ['required', 'string', 'max:15', 
                new UniqueDateRangeValidation('cnic_number', $request->input('start_date'), $request->input('end_date'))],
            'pec_number' => ['required', 'max:50', 
                new UniqueDateRangeValidation('pec_number', $request->input('start_date'), $request->input('end_date'))],
            'designation' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'salary' => 'required|numeric',
            'resume' => 'nullable|file|mimes:jpg,png,gif,pdf,doc,docx|max:2048'
        ]);

        $hr = new ContractorHumanResource();
        $hr->name = $request->name;
        $hr->father_name = $request->father_name;
        $hr->email = $request->email;
        $hr->mobile_number = $request->mobile_number;
        $hr->cnic_number = $request->cnic_number;
        $hr->pec_number = $request->pec_number;
        $hr->designation = $request->designation;
        $hr->start_date = $request->start_date;
        $hr->end_date = $request->end_date;
        $hr->salary = $request->salary;
        $hr->contractor_id = session('contractor_id');

        if ($request->hasFile('resume')) {
            $hr->addMedia($request->file('resume'))
                ->toMediaCollection('contractor_hr_resumes');
        }
 
        if ($hr->save()) {
            return redirect()->back()->with('success', 'Record has been added and will be placed under review. It will be visible once the moderation process is complete');
        }

        return redirect()->back()->with(['error' => 'An error occurred while saving the profiles.']);
    }
}