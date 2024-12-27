<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\District;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\DevelopmentProject;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDevelopmentProjectRequest;

class DevelopmentProjectController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $projects = DevelopmentProject::query()->withoutGlobalScope('published');

        $projects->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {

            return DataTables::of($projects)
                ->addIndexColumn()
                ->addColumn('district', function ($row) {
                    return $row->district?->name;
                })
                ->addColumn('chief_engineer', function ($row) {
                    return $row->chiefEngineer?->position;
                })
                ->editColumn('year_of_completion', function($row) {
                    return $row->year_of_completion?->format('j, F Y');
                })
                ->editColumn('commencement_date', function($row) {
                    return $row->commencement_date?->format('j, F Y');
                })
                ->editColumn('progress_percentage', function($row) {
                    return $row->progress_percentage . '%';
                })
                ->addColumn('uploaded_by', function ($row) {
                    return $row->user?->position 
                    ? '<a href="'.route('admin.users.show', $row->user->id).'" target="_blank">'.$row->user->position.'</a>' 
                    : ($row->user?->designation ?? 'N/A');
                })
                ->addColumn('action', function ($row) {
                    return view('admin.development_projects.partials.buttons', compact('row'))->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'uploaded_by'])
                ->make(true);
        }

        return view('admin.development_projects.index');
    }

    public function create()
    {
        $cat = [
            'districts' => District::all(),
            'chiefEngineers' => User::where('designation', 'Chief Engineer')->get(),
            'superintendentEngineers' => User::where('designation', 'Superintendent Engineer')->get(),
        ];
        
        return view('admin.development_projects.create', compact('cat'));
    }

    public function store(StoreDevelopmentProjectRequest $request)
    {
        $dev_project = new DevelopmentProject();
        $dev_project->name = $request->name;
        $dev_project->slug = Str::uuid();
        $dev_project->introduction = $request->introduction;
        $dev_project->total_cost = $request->total_cost;
        $dev_project->commencement_date = $request->commencement_date;
        $dev_project->district_id = $request->district_id;
        $dev_project->work_location = $request->work_location;
        $dev_project->ce_id = $request->chiefEnginner;
        $dev_project->se_id = $request->superintendentEngineer;
        $dev_project->progress_percentage = $request->progress_percentage;
        $dev_project->year_of_completion = $request->year_of_completion;
        $dev_project->status = 'Draft';

        $attachments = $request->file('attachments');

        if ($attachments) {
            foreach ($attachments as $attachment) {
                $dev_project->addMedia($attachment)->toMediaCollection('development_projects_attachments');
            }
        }

        if ($request->user()->developmentProjects()->save($dev_project)) {
            return redirect()->route('admin.development_projects.create')->with('success', 'Development Project added successfully');
        }

        return redirect()->route('admin.development_projects.index')->with('error', 'There is an error adding DevelopmentProject');
    }

    public function show(DevelopmentProject $DevelopmentProject)
    {
        return response()->json($DevelopmentProject);
    }

    public function publishDevelopmentProject(Request $request, $dev_projectId)
    {
        $dev_project = DevelopmentProject::withoutGlobalScope('published')->findOrFail($dev_projectId);
        if ($dev_project->status === 'Draft') {
            $dev_project->status = $request->progress_percentage == 100 ? 'Completed' : 'In-Progress';
            $message = 'Project has been published successfully.';
        } else {
            $dev_project->status = 'Draft';
            $message = 'Project has been unpublished.';
        }
        $dev_project->save();
        return response()->json(['success' => $message], 200);
    }

    public function archiveDevelopmentProject(Request $request, $dev_projectId)
    {
        $dev_project = DevelopmentProject::findOrFail($dev_projectId);
        if ($dev_project->status != 'Draft') {
            $dev_project->status = 'Archived';
            $dev_project->save(); 
            return response()->json(['success' => 'Project has been archived successfully.'], 200);
        }
        return response()->json(['success' => 'Project cannot be archived.'], 403);
    }

    public function showDetail(DevelopmentProject $DevelopmentProject)
    {
        $cat = [
            'districts' => District::all(),
            'chiefEngineers' => User::where('designation', 'Chief Engineer')->get(),
            'superintendentEngineers' => User::where('designation', 'Superintendent Engineer')->get(),
            'status' => ['In-Progess', 'On-Hold', 'Completed'],
        ];

        $html = view('admin.development_projects.partials.detail', compact('DevelopmentProject', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
            'id'    => 'required|integer|exists:development_projects,id',
        ]);

        $project = DevelopmentProject::findOrFail($request->id);

        $project->{$request->field} = $request->value;

        if ($project->isDirty($request->field)) {
            $project->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function destroy(DevelopmentProject $DevelopmentProject)
    {
        if ($DevelopmentProject->delete()) {
            return response()->json(['success' => 'DevelopmentProject has been deleted successfully.']);
        }
        return response()->json(['error' => 'Only draft projects can be deleted.']);
    }
}
