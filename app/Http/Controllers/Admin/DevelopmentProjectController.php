<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;

use App\Models\District;
use App\Helpers\Database;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\SearchBuilder;
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

        $relationMappings = [
            'chief_engineer' => 'chiefEngineer.currentPosting.office.name',
            'uploaded_by' => 'user.currentPosting.designation.name'
        ];

        if ($request->ajax()) {

            $dataTable = DataTables::of($projects)
                ->addIndexColumn()
                ->addColumn('district', function ($row) {
                    return $row->district?->name;
                })
                ->addColumn('chief_engineer', function ($row) {
                    return $row->chiefEngineer?->currentPosting?->office->name;
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
                    return $row->user->currentPosting?->designation->name 
                    ? '<a href="'.route('admin.apps.hr.users.show', $row->user->id).'" target="_blank">'.$row->user->currentPosting?->designation->name .'</a>' 
                    : ($row->user->currentPosting?->designation->name  ?? 'N/A');
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
                ->rawColumns(['action', 'uploaded_by']);

            if ($request->input('search.value')) {
                Database::applyRelationalSearch($dataTable, $relationMappings);
            }

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request, $relationMappings) {
                    $sb = new SearchBuilder(
                        $request, 
                        $query,
                        [],
                        $relationMappings,
                    );
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.development_projects.index');
    }

    public function create()
    {
        $cat = [
            'districts' => District::all(),
            'chiefEngineers' => User::whereHas('currentPosting.designation', function($query) {
                $query->where('name', 'Chief Engineer');
            })->get(),
        ];
        
        $html = view('admin.development_projects.partials.create', compact('cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
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
            return response()->json(['success' => 'Development Project added successfully'], 200);
        }

        return response()->json(['error' => 'There is an error adding DevelopmentProject'], 500);
    }

    public function show(DevelopmentProject $development_project)
    {
        return response()->json($development_project);
    }

    public function publishDevelopmentProject(Request $request, DevelopmentProject $development_project)
    {
        if ($development_project->status === 'Draft') {
            $development_project->status = $request->progress_percentage == 100 ? 'Completed' : 'In-Progress';
            $development_project->published_at = now();
            $message = 'Project has been published successfully.';
        } else {
            $development_project->status = 'Draft';
            $message = 'Project has been unpublished.';
        }
        $development_project->save();
        return response()->json(['success' => $message], 200);
    }

    public function archiveDevelopmentProject(Request $request, DevelopmentProject $development_project)
    {
        if ($development_project->status != 'Draft') {
            $development_project->status = 'Archived';
            $development_project->save(); 
            return response()->json(['success' => 'Project has been archived successfully.'], 200);
        }
        return response()->json(['success' => 'Project cannot be archived.'], 403);
    }

    public function showDetail(DevelopmentProject $development_project)
    {
        $cat = [
            'districts' => District::all(),
            'chiefEngineers' => User::whereHas('currentPosting.designation', function($query) {
                $query->where('name', 'Chief Engineer');
            })->get(),
            'status' => ['In-Progess', 'On-Hold', 'Completed'],
        ];

        $html = view('admin.development_projects.partials.detail', compact('development_project', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, DevelopmentProject $development_project)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $development_project->{$request->field} = $request->value;

        if ($development_project->isDirty($request->field)) {
            $development_project->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function destroy(DevelopmentProject $development_project)
    {
        if ($development_project->delete()) {
            return response()->json(['success' => 'DevelopmentProject has been deleted successfully.']);
        }
        return response()->json(['error' => 'Only draft projects can be deleted.']);
    }

    public function updateComments(Request $request, DevelopmentProject $development_project)
    {
        $validated = $request->validate([
            'comments_allowed' => 'required|boolean',
        ]);

        $development_project->update($validated);

        return response()->json([
            'success' => 'Comments visibility updated',
        ]);
    }
}
