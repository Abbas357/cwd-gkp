<?php

namespace App\Http\Controllers\Consultant;

use App\Models\District;
use App\Models\Consultant;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ConsultantProject;
use App\Http\Controllers\Controller;
use App\Models\ConsultantHumanResource;

class ConsultantController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $consultants = Consultant::query();

        $consultants->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($consultants)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.consultants.partials.buttons', compact('row'))->render();
                })
                ->addColumn('district', function ($row) {
                    return $row->district ? $row->district->name : 'N/A';
                })
                ->addColumn('status', function ($row) {
                    return view('modules.consultants.partials.status', compact('row'))->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at?->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'status']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('modules.consultants.index');
    }

    public function consultants(Request $request)
    {
        return $this->getApiResults(
            $request,
            Consultant::class, 
            [
                'searchColumns' => ['name', 'email', 'address', 'sector'],
                'withRelations' => ['district'],
                'textFormat' => function($consultant) {
                    return $consultant->name . ' - ' . ($consultant->sector ?? '');
                },
                'searchRelations' => [
                    'district' => ['name'],
                ],
                'status' => 'approved',
                'orderBy' => 'id',
            ]
        );
    }

    public function detail(Consultant $consultant)
    {
        $cat = [
            'districts' => District::all(),
            'status' => ['draft', 'rejected', 'approved'],
            'sectors' => ['Road', 'Building', 'Bridge'],
        ];

        if (!$consultant) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Consultant detail',
                ],
            ]);
        }
        $html = view('modules.consultants.partials.detail', compact('consultant', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function report(Request $request)
{
    $selectedConsultantId = $request->get('consultant_id');
    $consultants = Consultant::where('status', 'approved')->orderBy('name')->get();

    $reportData = null;

    if ($selectedConsultantId) {
        $consultant = Consultant::with(['humanResources', 'projects'])->findOrFail($selectedConsultantId);

        // Get all active projects with HR assignments
        $activeProjects = ConsultantProject::where('consultant_id', $selectedConsultantId)
            ->where('status', 'active')
            ->whereNotNull('hr')
            ->get();

        // Get all approved HR for this consultant
        $allHr = ConsultantHumanResource::where('consultant_id', $selectedConsultantId)
            ->where('status', 'approved')
            ->get();

        // Track HR assignments across projects
        $hrAssignments = [];
        $projectDetails = [];

        foreach ($activeProjects as $project) {
            $hrIds = $project->getHrIds();

            $projectDetails[] = [
                'id' => $project->id,
                'name' => $project->name,
                'adp_number' => $project->adp_number,
                'scheme_code' => $project->scheme_code,
                'start_date' => $project->start_date->format('j, F Y'),
                'end_date' => $project->end_date->format('j, F Y'),
                'estimated_cost' => $project->estimated_cost,
                'hr_count' => count($hrIds),
                'hr_ids' => $hrIds,
                'assigned_hr' => $allHr->whereIn('id', $hrIds)->values()
            ];

            // Track HR assignments
            if (!empty($hrIds) && is_array($hrIds)) {
                foreach ($hrIds as $hrId) {
                    if (!isset($hrAssignments[$hrId])) {
                        $hrAssignments[$hrId] = [];
                    }
                    $hrAssignments[$hrId][] = [
                        'project_id' => $project->id,
                        'project_name' => $project->name,
                        'start_date' => $project->start_date->format('j, F Y'),
                        'end_date' => $project->end_date->format('j, F Y')
                    ];
                }
            }
        }

        // Sort projects by HR count (descending - most HR at top)
        usort($projectDetails, function($a, $b) {
            return $b['hr_count'] - $a['hr_count'];
        });

        // Identify HR with multiple assignments
        $multipleAssignmentHr = [];
        foreach ($hrAssignments as $hrId => $assignments) {
            if (count($assignments) > 1) {
                $hr = $allHr->find($hrId);
                if ($hr) {
                    $multipleAssignmentHr[] = [
                        'hr' => $hr,
                        'assignments' => $assignments,
                        'project_count' => count($assignments)
                    ];
                }
            }
        }

        // Get unassigned HR
        $assignedHrIds = array_keys($hrAssignments);
        $unassignedHr = $allHr->whereNotIn('id', $assignedHrIds)->values();

        // Sort all HR by project count (descending - most projects at top)
        $sortedAllHr = $allHr->sortByDesc(function($hr) use ($hrAssignments) {
            return isset($hrAssignments[$hr->id]) ? count($hrAssignments[$hr->id]) : 0;
        })->values();

        $reportData = [
            'consultant' => $consultant,
            'total_projects' => $activeProjects->count(),
            'total_hr' => $allHr->count(),
            'assigned_hr_count' => count($assignedHrIds),
            'unassigned_hr_count' => $unassignedHr->count(),
            'multiple_assignment_count' => count($multipleAssignmentHr),
            'projects' => $projectDetails, // Now sorted by HR count (descending)
            'hr_assignments' => $hrAssignments,
            'multiple_assignment_hr' => $multipleAssignmentHr,
            'unassigned_hr' => $unassignedHr,
            'all_hr' => $sortedAllHr // Now sorted by project count (descending)
        ];
    }

    return view('modules.consultants.report', compact('consultants', 'selectedConsultantId', 'reportData'));
}

    public function projects(Consultant $consultant)
    {
        $cat = [
            'districts' => District::all(),
            'status' => ['draft', 'rejected', 'approved'],
        ];

        if (!$consultant) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Consultant detail',
                ],
            ]);
        }
        $html = view('modules.consultants.partials.detail', compact('Consultant', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Consultant $consultant)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required',
        ]);

        $consultant->{$request->field} = $request->value;

        if ($consultant->isDirty($request->field)) {
            $consultant->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function uploadFile(Request $request, Consultant $consultant)
    {
        $file = $request->file;
        $collection = $request->collection;
        $consultant->addMedia($file)->toMediaCollection($collection);
        if ($consultant->save()) {
            return response()->json(['success' => 'File Updated']);
        }
        return response()->json(['error' => 'Error Uploading File']);
    }
}
