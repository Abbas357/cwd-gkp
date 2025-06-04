<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ConsultantHumanResource;
use App\Rules\UniqueDateRangeValidation;
use App\Rules\UniqueEmployeeAcrossConsultantsRule;

class ConsultantHumanResourceController extends Controller
{
    public function create()
    {
        $employees = ConsultantHumanResource::where('consultant_id', session('consultant_id'))->paginate(10);
        return view('site.consultants.hr_profile', compact('employees'));
    }

    public function store(Request $request)
    {
        $consultantId = session('consultant_id');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 
                'email', 
                'max:255',
                // Check within same consultant for duplicates
                new UniqueDateRangeValidation(
                    'email', 
                    $request->input('start_date'), 
                    $request->input('end_date'), 
                    \App\Models\ConsultantHumanResource::class,
                    null,
                    ['consultant_id' => $consultantId]
                )
            ],
            'contact_number' => [
                'required', 
                'string', 
                'max:255',
                new UniqueDateRangeValidation(
                    'contact_number', 
                    $request->input('start_date'), 
                    $request->input('end_date'), 
                    \App\Models\ConsultantHumanResource::class,
                    null,
                    ['consultant_id' => $consultantId]
                )
            ],
            'cnic_number' => [
                'required', 
                'string', 
                'max:15',
                new UniqueDateRangeValidation(
                    'cnic_number', 
                    $request->input('start_date'), 
                    $request->input('end_date'), 
                    \App\Models\ConsultantHumanResource::class,
                    null,
                    ['consultant_id' => $consultantId]
                ),
                // Primary check for employee conflicts across consultants using CNIC
                new UniqueEmployeeAcrossConsultantsRule(
                    'cnic_number',
                    $request->input('start_date'),
                    $request->input('end_date'),
                    $consultantId
                )
            ],
            'pec_number' => [
                'nullable',
                'max:50'
            ],
            'designation' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'salary' => 'numeric'
        ]);

        $hr = new ConsultantHumanResource();
        $hr->name = $request->name;
        $hr->email = $request->email;
        $hr->contact_number = $request->contact_number;
        $hr->cnic_number = $request->cnic_number;
        $hr->pec_number = $request->pec_number;
        $hr->designation = $request->designation;
        $hr->start_date = $request->start_date;
        $hr->end_date = $request->end_date;
        $hr->salary = $request->salary;
        $hr->consultant_id = $consultantId;

        if ($hr->save()) {
            return redirect()->back()->with('success', 'Record has been added and will be placed under review. It will be visible once the moderation process is complete');
        }

        return redirect()->back()->with(['error' => 'An error occurred while saving the profiles.']);
    }
}