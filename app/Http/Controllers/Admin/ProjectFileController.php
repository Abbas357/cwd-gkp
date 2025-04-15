<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;

use App\Models\Category;
use App\Helpers\Database;
use App\Models\ProjectFile;
use Illuminate\Http\Request;
use App\Helpers\SearchBuilder;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectFileRequest;

class ProjectFileController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $projects = ProjectFile::query()->withoutGlobalScope('published');

        $projects->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        $relationMappings = [
            'uploaded_by' => 'publishBy.currentPosting.designation.name'
        ];

        if ($request->ajax()) {
            $dataTable = Datatables::of($projects)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.project_files.partials.buttons', compact('row'))->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.project_files.partials.status', compact('row'))->render();
                })
                ->addColumn('file', function ($row) {
                    if ($row->hasMedia('project_files')) {
                        return '<a target="_blank" href="' . $row->getFirstMediaUrl('project_files') . '" class="btn btn-light bi bi-file-earmark fs-4"></a>';
                    } elseif ($row->file_link) {
                        return '<a target="_blank" href="' . $row->file_link . '" class="btn btn-light bi bi-link-45deg fs-4"></a>';
                    }
                    return '';
                })
                ->addColumn('uploaded_by', function ($row) {
                    return $row->publishBy?->currentPosting?->designation->name 
                        ? '<a href="' . route('admin.apps.hr.users.show', $row->publishBy->id) . '" target="_blank">' . $row->publishBy?->currentPosting?->designation->name . '</a>'
                        : ($row->publishBy?->currentPosting?->designation->name ?? 'N/A');
                })
                ->addColumn('project', function ($row) {
                    return $row->project->name;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'status', 'file', 'uploaded_by']);

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

        return view('admin.project_files.index');
    }

    public function create()
    {
        $cat = [
            'projects' => Project::select('id', 'name')->get(),
            'file_type' => Category::where('type', 'file_type')->get()
        ];

        $html = view('admin.project_files.partials.create', compact('cat'))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreProjectFileRequest $request)
    {
        $project = new ProjectFile();
        $project->file_name = $request->file_name;
        $project->file_type = $request->file_type;
        $project->file_link = $request->file_link;
        $project->project_id = $request->project_id;
        $project->status = 'draft';

        if ($request->hasFile('file')) {
            $project->addMedia($request->file('file'))
                ->toMediaCollection('project_files');
        }

        if ($project->save()) {
            return response()->json(['success' => 'File Added successfully']);
        }
        return response()->json(['danger' => 'There is an error adding your project file']);
    }

    public function show(ProjectFile $project_file)
    {
        return response()->json($project_file);
    }

    public function publishProjectFile(Request $request, ProjectFile $project_file)
    {
        if ($project_file->status === 'draft') {
            $project_file->published_at = now();
            $project_file->status = 'published';
            $message = 'File has been published successfully.';
        } else {
            $project_file->status = 'draft';
            $message = 'File has been unpublished.';
        }
        $project_file->published_by = $request->user()->id;
        $project_file->save();
        return response()->json(['success' => $message], 200);
    }

    public function archiveProjectFile(Request $request, ProjectFile $project_file)
    {
        if (!is_null($project_file->published_at)) {
            $project_file->status = 'archived';
            $project_file->save();
            return response()->json(['success' => 'File has been archived successfully.'], 200);
        }
        return response()->json(['success' => 'File cannot be archived.'], 403);
    }

    public function showDetail(ProjectFile $project_file)
    {
        if (!$project_file) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load ProjectFile Detail',
                ],
            ]);
        }

        $cat = [
            'file_type' => Category::where('type', 'file_type')->get(),
            'projects' => Project::select('id', 'name')->get(),
        ];

        $html = view('admin.project_files.partials.detail', compact('project_file', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, ProjectFile $project_file)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        if (in_array($project_file->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived downlods cannot be updated'], 403);
        }

        $project_file->{$request->field} = $request->value;

        if ($project_file->isDirty($request->field)) {
            $project_file->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }


    public function uploadFile(Request $request, ProjectFile $project_file)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,docx,pptx, txt,jpg,png|max:10240', 
        ]);

        if (in_array($project_file->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived Project files cannot be updated'], 403); 
        }

        try {
            $file = $request->file('file');
            $project_file->addMedia($file)->toMediaCollection('project_files');

            return response()->json(['success' => 'File uploaded successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(ProjectFile $project_file)
    {
        if ((request()->user()->isAdmin() || ($project_file->status === 'draft' && is_null($project_file->published_at))) && $project_file->delete()) {
            return response()->json(['success' => 'File has been deleted successfully.']);
        }

        return response()->json(['error' => 'Published, Archived, or Draft project files that were once published cannot be deleted.']);
    }
}
