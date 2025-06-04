<?php

namespace App\Http\Controllers\Consultant;

use App\Models\Consultant;
use Illuminate\Http\Request;
use App\Models\ConsultantProject;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\ConsultantHumanResource;

class ConsultantProjectController extends Controller
{    
    public function detail(Consultant $consultant)
    {
        $cat = [
            'districts' => District::all(),
            'statuses' => ['active','completed','on_hold','cancelled'],
        ];
        $projects = $consultant->projects()->get();
        
        // Get all approved HR for this consultant
        $allHr = ConsultantHumanResource::where('consultant_id', $consultant->id)
            ->where('status', 'approved')
            ->orderBy('name')
            ->get();
            
        if (!$projects) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load projects detail',
                ],
            ]);
        }
        
        $html = view('modules.consultants.partials.projects', compact('projects', 'cat', 'allHr'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $project = ConsultantProject::findOrFail($id);
        $validatedData = $request->validate([
            'field' => 'required|string',
            'value' => 'required'
        ]);

        try {
            $project->{$validatedData['field']} = $validatedData['value'];
            $project->save();

            return response()->json([
                'success' => 'Project updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 'Failed to update project'
            ], 500);
        }
    }

    /**
     * Update HR assignments for a project
     */
    public function updateHrAssignments(Request $request, $id)
    {
        $project = ConsultantProject::findOrFail($id);
        
        $validatedData = $request->validate([
            'hr_ids' => 'nullable|array',
            'hr_ids.*' => 'exists:consultant_human_resources,id',
        ]);

        try {
            // Validate that selected HR belong to the project's consultant
            if (!empty($validatedData['hr_ids'])) {
                $invalidHr = ConsultantHumanResource::whereIn('id', $validatedData['hr_ids'])
                    ->where('consultant_id', '!=', $project->consultant_id)
                    ->orWhere('status', '!=', 'approved')
                    ->exists();
                    
                if ($invalidHr) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Some selected HR do not belong to this consultant or are not approved.'
                    ], 400);
                }
            }

            // Update HR assignments
            $project->setHrIds($validatedData['hr_ids'] ?? []);
            $project->save();

            // Get updated HR names for display
            $hrNames = [];
            if (!empty($validatedData['hr_ids'])) {
                $hrNames = ConsultantHumanResource::whereIn('id', $validatedData['hr_ids'])
                    ->pluck('name')
                    ->toArray();
            }

            return response()->json([
                'success' => true,
                'message' => 'HR assignments updated successfully',
                'hr_names' => $hrNames
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update HR assignments: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available HR for a specific project
     */
    public function getAvailableHr(Request $request, $id)
    {
        $project = ConsultantProject::findOrFail($id);
        
        try {
            // Get all approved HR for this consultant
            $allHr = ConsultantHumanResource::where('consultant_id', $project->consultant_id)
                ->where('status', 'approved')
                ->orderBy('name')
                ->get();

            // Get currently assigned HR IDs
            $assignedHrIds = $project->getHrIds() ?? [];

            // Prepare HR data with assignment status
            $hrData = $allHr->map(function ($hr) use ($assignedHrIds) {
                return [
                    'id' => $hr->id,
                    'name' => $hr->name,
                    'designation' => $hr->designation,
                    'is_assigned' => in_array($hr->id, $assignedHrIds)
                ];
            });

            return response()->json([
                'success' => true,
                'hr_list' => $hrData,
                'assigned_hr_ids' => $assignedHrIds
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch HR data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $machine = ConsultantProject::findOrFail($id);        
        if($machine->delete()) {
            return response()->json(['success' => 'Project deleted successfully'], 200);
        }
        return response()->json(['error' => 'Failed to delete project'], 500);
    }
}