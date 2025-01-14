<?php

namespace App\Http\Controllers\Site;

use App\Models\Contractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ContractorHumanResource;
use App\Models\ContractorRegistration;

class ContractorHumanResourceController extends Controller
{
    public function create()
    {
        return view('site.contractors.hr_profile');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_number' => 'required|string|max:255',
            'cnic_number' => 'required|string|max:15',
            'pec_number' => 'required|string|max:50',
            'designation' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
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