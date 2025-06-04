<?php

namespace App\Http\Controllers\Site;

use App\Models\District;
use Illuminate\Http\Request;
use App\Models\ConsultantProject;
use App\Http\Controllers\Controller;
use App\Models\ConsultantHumanResource;

class ConsultantProjectController extends Controller
{
    public function create()
    {
        $consultantId = session('consultant_id');
        
        $projects = ConsultantProject::where('consultant_id', $consultantId)->paginate(10);
        
        $availableHr = $this->getAvailableHumanResources($consultantId);

        $districts = District::all();
        
        return view('site.consultants.projects', compact('projects', 'availableHr', 'districts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district_id' => 'nullable|string|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'estimated_cost' => 'nullable|integer',
            'hr' => 'nullable|array', // Array of HR IDs
            'hr.*' => 'exists:consultant_human_resources,id',
            'remarks' => 'nullable|string',
        ]);

        $consultantId = session('consultant_id');

        // Validate that selected HR belong to the current consultant and are available
        if ($request->hr) {
            $validationErrors = $this->validateHrSelection($request->hr, $consultantId);
            if (!empty($validationErrors)) {
                return redirect()->back()->withErrors($validationErrors)->withInput();
            }
        }

        $project = new ConsultantProject();
        $project->name = $request->name;
        $project->district_id = $request->district_id;
        $project->estimated_cost = $request->estimated_cost;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->status = 'active';
        $project->remarks = $request->remarks;
        $project->consultant_id = $consultantId;

        if ($request->hr) {
            $project->setHrIds($request->hr);
        }

        if ($project->save()) {
            return redirect()->back()->with('success', 'Record has been added and will be placed under review. It will be visible once the moderation process is complete');
        }

        return redirect()->back()->with(['error' => 'An error occurred while saving the projects details.']);
    }

    private function getAvailableHumanResources($consultantId)
    {
        // Get all HR IDs that are currently assigned to active projects
        $activeProjects = ConsultantProject::where('consultant_id', $consultantId)
            ->where('status', 'active')
            ->whereNotNull('hr')
            ->get();

        $assignedHrIds = [];
        foreach ($activeProjects as $project) {
            $hrIds = $project->getHrIds();
            if (!empty($hrIds)) {
                $assignedHrIds = array_merge($assignedHrIds, $hrIds);
            }
        }
        $assignedHrIds = array_unique($assignedHrIds);

        // Get approved HR that are not assigned to any active project
        return ConsultantHumanResource::where('consultant_id', $consultantId)
            ->where('status', 'approved')
            ->whereNotIn('id', $assignedHrIds)
            ->orderBy('name')
            ->get();
    }

    /**
     * Validate HR selection for assignment
     */
    private function validateHrSelection($hrIds, $consultantId)
    {
        $errors = [];
        
        foreach ($hrIds as $hrId) {
            $hr = ConsultantHumanResource::find($hrId);
            
            if (!$hr) {
                $errors[] = "Selected HR with ID {$hrId} not found.";
                continue;
            }

            // Check if HR belongs to the current consultant
            if ($hr->consultant_id != $consultantId) {
                $errors[] = "HR {$hr->name} does not belong to your consultant profile.";
            }

            // Check if HR is approved
            if ($hr->status !== 'approved') {
                $errors[] = "HR {$hr->name} is not approved for assignment.";
            }

            // Check if HR is already assigned to an active project
            if ($hr->isCurrentlyAssigned()) {
                $currentProject = $hr->currentActiveProject();
                $errors[] = "HR {$hr->name} is already assigned to project: {$currentProject->name}";
            }
        }

        return $errors;
    }
}
