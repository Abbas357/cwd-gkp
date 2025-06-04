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
        
        // Get all approved HR (not just available ones)
        $allHr = $this->getAllApprovedHumanResources($consultantId);
        
        // Get HR assignment info for warnings
        $hrAssignmentInfo = $this->getHrAssignmentInfo($consultantId);

        $districts = District::all();
        
        // Debug: Add this to check what's being passed
        // dd($hrAssignmentInfo); // Uncomment this line to debug
        
        return view('site.consultants.projects', compact('projects', 'allHr', 'hrAssignmentInfo', 'districts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'adp_number' => 'required|string|max:255',
            'scheme_code' => 'required|string|max:255',
            'district_id' => 'nullable|string|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'estimated_cost' => 'nullable|integer',
            'hr' => 'nullable|array', // Array of HR IDs
            'hr.*' => 'exists:consultant_human_resources,id',
            'remarks' => 'nullable|string',
            'confirm_reassignment' => 'nullable|boolean', // New field for confirmation
        ]);

        $consultantId = session('consultant_id');

        // Validate that selected HR belong to the current consultant
        if ($request->hr) {
            $validationErrors = $this->validateHrOwnership($request->hr, $consultantId);
            if (!empty($validationErrors)) {
                return redirect()->back()->withErrors($validationErrors)->withInput();
            }

            // Check for date-based assignment conflicts and require confirmation
            $assignedHrWarnings = $this->getDateBasedAssignmentWarnings($request->hr, $consultantId, $request->start_date, $request->end_date);
            if (!empty($assignedHrWarnings) && !$request->confirm_reassignment) {
                return redirect()->back()
                    ->withInput()
                    ->with('hr_warnings', $assignedHrWarnings)
                    ->with('warning', 'Some selected HR have conflicting project assignments during the specified date range. Please confirm to proceed.');
            }
        }

        $project = new ConsultantProject();
        $project->name = $request->name;
        $project->adp_number = $request->adp_number;
        $project->scheme_code = $request->scheme_code;
        $project->district_id = $request->district_id;
        $project->estimated_cost = $request->estimated_cost;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
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

    /**
     * Get all approved human resources for the consultant
     */
    private function getAllApprovedHumanResources($consultantId)
    {
        return ConsultantHumanResource::where('consultant_id', $consultantId)
            ->where('status', 'approved')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get HR assignment information for warnings based on date ranges
     * FIXED: This method had issues with date comparison and data retrieval
     */
    private function getHrAssignmentInfo($consultantId)
    {
        $currentDate = now()->toDateString();
        
        // Get projects that are currently active based on date range
        $projects = ConsultantProject::where('consultant_id', $consultantId)
            ->where('status', 'active')
            ->whereNotNull('hr')
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->where('start_date', '<=', $currentDate) // Project has started
            ->where('end_date', '>=', $currentDate)   // Project hasn't ended
            ->get();

        $assignmentInfo = [];
        
        foreach ($projects as $project) {
            $hrIds = $project->getHrIds();
            
            // Make sure getHrIds() returns an array and is not empty
            if (!empty($hrIds) && is_array($hrIds)) {
                foreach ($hrIds as $hrId) {
                    // Convert to integer if it's a string
                    $hrId = (int) $hrId;
                    
                    $assignmentInfo[$hrId] = [
                        'project_name' => $project->name,
                        'project_id' => $project->id,
                        'start_date' => $project->start_date,
                        'end_date' => $project->end_date,
                        'is_currently_active' => true
                    ];
                }
            }
        }

        return $assignmentInfo;
    }

    /**
     * Alternative method to get HR assignment info if the above doesn't work
     * This method checks all projects and determines if they're currently active
     */
    private function getHrAssignmentInfoAlternative($consultantId)
    {
        $currentDate = now()->toDateString();
        
        // Get ALL active projects for this consultant
        $projects = ConsultantProject::where('consultant_id', $consultantId)
            ->where('status', 'active')
            ->whereNotNull('hr')
            ->get();

        $assignmentInfo = [];
        
        foreach ($projects as $project) {
            // Check if project has start and end dates
            if ($project->start_date && $project->end_date) {
                // Check if current date is within project date range
                $isCurrentlyActive = $currentDate >= $project->start_date && $currentDate <= $project->end_date;
                
                if ($isCurrentlyActive) {
                    $hrIds = $project->getHrIds();
                    
                    if (!empty($hrIds) && is_array($hrIds)) {
                        foreach ($hrIds as $hrId) {
                            $hrId = (int) $hrId;
                            
                            $assignmentInfo[$hrId] = [
                                'project_name' => $project->name,
                                'project_id' => $project->id,
                                'start_date' => $project->start_date,
                                'end_date' => $project->end_date,
                                'is_currently_active' => true
                            ];
                        }
                    }
                }
            }
        }

        return $assignmentInfo;
    }

    private function getAssignedHrWarnings($hrIds, $consultantId)
    {
        $warnings = [];
        $currentDate = now()->toDateString();
        
        foreach ($hrIds as $hrId) {
            $hr = ConsultantHumanResource::find($hrId);
            
            if ($hr) {
                // Check if HR is currently assigned to any active project within date range
                $currentAssignment = $this->getCurrentActiveAssignment($hr, $currentDate);
                
                if ($currentAssignment) {
                    $warnings[] = [
                        'hr_id' => $hrId,
                        'hr_name' => $hr->name,
                        'current_project' => $currentAssignment['project_name'],
                        'start_date' => $currentAssignment['start_date'],
                        'end_date' => $currentAssignment['end_date'],
                        'message' => "HR {$hr->name} is currently assigned to project: {$currentAssignment['project_name']} (Active: {$currentAssignment['start_date']} to {$currentAssignment['end_date']})"
                    ];
                }
            }
        }

        return $warnings;
    }

    /**
     * Validate HR ownership (belongs to consultant and is approved)
     */
    private function validateHrOwnership($hrIds, $consultantId)
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
        }

        return $errors;
    }

    /**
     * Get warnings for HR with date-based assignment conflicts
     */
    private function getDateBasedAssignmentWarnings($hrIds, $consultantId, $newStartDate, $newEndDate)
    {
        $warnings = [];
        
        // If no dates provided, fall back to current date check
        if (!$newStartDate || !$newEndDate) {
            return $this->getAssignedHrWarnings($hrIds, $consultantId);
        }
        
        foreach ($hrIds as $hrId) {
            $hr = ConsultantHumanResource::find($hrId);
            
            if ($hr) {
                // Check if HR has any overlapping assignments
                $conflictingAssignments = $this->getConflictingAssignments($hr, $newStartDate, $newEndDate);
                
                foreach ($conflictingAssignments as $assignment) {
                    $warnings[] = [
                        'hr_id' => $hrId,
                        'hr_name' => $hr->name,
                        'current_project' => $assignment['project_name'],
                        'start_date' => $assignment['start_date'],
                        'end_date' => $assignment['end_date'],
                        'conflict_type' => $assignment['conflict_type'],
                        'message' => "HR {$hr->name} has {$assignment['conflict_type']} assignment in project: {$assignment['project_name']} ({$assignment['start_date']} to {$assignment['end_date']})"
                    ];
                }
            }
        }

        return $warnings;
    }

    /**
     * Get conflicting assignments for an HR based on date range overlap
     */
    private function getConflictingAssignments($hr, $newStartDate, $newEndDate)
    {
        $conflicts = [];
        
        $projects = ConsultantProject::where('consultant_id', $hr->consultant_id)
            ->where('status', 'active')
            ->whereNotNull('hr')
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->get();

        foreach ($projects as $project) {
            $hrIds = $project->getHrIds();
            if (!empty($hrIds) && is_array($hrIds) && in_array($hr->id, $hrIds)) {
                // Check for date overlap
                $projectStart = $project->start_date;
                $projectEnd = $project->end_date;
                
                // Check if there's any overlap between the date ranges
                if ($this->datesOverlap($newStartDate, $newEndDate, $projectStart, $projectEnd)) {
                    $currentDate = now()->toDateString();
                    
                    // Determine conflict type
                    $conflictType = 'overlapping';
                    if ($currentDate >= $projectStart && $currentDate <= $projectEnd) {
                        $conflictType = 'currently active';
                    } elseif ($projectStart > $currentDate) {
                        $conflictType = 'future';
                    } else {
                        $conflictType = 'past';
                    }
                    
                    $conflicts[] = [
                        'project_name' => $project->name,
                        'project_id' => $project->id,
                        'start_date' => $projectStart,
                        'end_date' => $projectEnd,
                        'conflict_type' => $conflictType
                    ];
                }
            }
        }

        return $conflicts;
    }

    /**
     * Check if two date ranges overlap
     */
    private function datesOverlap($start1, $end1, $start2, $end2)
    {
        return $start1 <= $end2 && $end1 >= $start2;
    }

    /**
     * Get current active assignment for an HR based on date range
     */
    private function getCurrentActiveAssignment($hr, $currentDate)
    {
        $projects = ConsultantProject::where('consultant_id', $hr->consultant_id)
            ->where('status', 'active')
            ->whereNotNull('hr')
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->get();

        foreach ($projects as $project) {
            $hrIds = $project->getHrIds();
            if (!empty($hrIds) && is_array($hrIds) && in_array($hr->id, $hrIds)) {
                return [
                    'project_name' => $project->name,
                    'project_id' => $project->id,
                    'start_date' => $project->start_date,
                    'end_date' => $project->end_date
                ];
            }
        }

        return null;
    }
}