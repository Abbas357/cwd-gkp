<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreProjectRequest;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $projects = Project::query();

            $dataTable = DataTables::of($projects)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.projects.partials.buttons', compact('row'))->render();
                })
                ->rawColumns(['action']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }
            return $dataTable->toJson();
        }

        return view('admin.projects.index');
    }

    public function create()
    {
        $html = view('admin.projects.partials.create')->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreProjectRequest $request)
    {
        $project = new Project();
        $project->name = $request->name;
        $project->introduction = $request->introduction;
        $project->funding_source = $request->funding_source;
        $project->location = $request->location;
        $project->status = 'pending';
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->budget = $request->budget;

        if ($request->hasFile('attachment')) {
            $project->addMedia($request->file('attachment'))
                ->toMediaCollection('project_documents');
        }

        if($project->save()) {
            return response()->json(['success' => 'Project added successfully']);
        } else {
            return response()->json(['error' => 'There is an error adding the project']);
        }

    }

    public function show(Project $project)
    {
        return response()->json($project);
    }

    public function showDetail(Project $project)
    {

        $cat = [
            'news_category' => Category::where('type', 'news_category')->get(),
        ];

        $html = view('admin.projects.partials.detail', compact('project', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Project $project)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $project->{$request->field} = $request->value;

        if ($project->isDirty($request->field)) {
            $project->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function destroy(Project $project)
    {
        if ($project->delete()) {
            return response()->json(['success' => 'Project has been deleted successfully.']);
        }
        return response()->json(['error' => 'Only draft projects can be deleted.']);
    }
}
