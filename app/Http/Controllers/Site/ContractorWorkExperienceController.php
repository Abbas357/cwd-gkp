<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContractorWorkExperience;

class ContractorWorkExperienceController extends Controller
{
    public function create()
    {
        $experiences = ContractorWorkExperience::where('contractor_id', session('contractor_id'))->paginate(10);
        return view('site.contractors.work_experience', compact('experiences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'adp_number' => 'required|string|max:50',
            'project_name' => 'required|string',
            'project_cost' => 'nullable|string|max:100',
            'commencement_date' => 'required|date|max:50',
            'completion_date' => 'nullable|date|max:50',
            'project_status' => 'nullable',
            'work_order' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,gif|max:5000',
        ]);

        $experince = new ContractorWorkExperience();
        $experince->adp_number = $request->adp_number;
        $experince->project_name = $request->project_name;
        $experince->project_cost = $request->project_cost;
        $experince->commencement_date = $request->commencement_date;
        $experince->completion_date = $request->completion_date;
        $experince->project_status = $request->project_status;
        $experince->contractor_id = session('contractor_id');

        if ($request->hasFile('work_order')) {
            $experince->addMedia($request->file('work_order'))
                ->toMediaCollection('contractor_work_orders');
        }

        if ($experince->save()) {
            return redirect()->back()->with('success', 'Record has been added and will be placed under review. It will be visible once the moderation process is complete');
        }

        return redirect()->back()->with(['error' => 'An error occurred while saving the work experince.']);
    }
}
