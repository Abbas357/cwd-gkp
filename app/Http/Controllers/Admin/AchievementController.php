<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Achievement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreAchievementRequest;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $achievements = Achievement::query()->withoutGlobalScope('published');

        $achievements->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($achievements)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.achievements.partials.buttons', compact('row'))->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.achievements.partials.status', compact('row'))->render();
                })
                ->addColumn('uploaded_by', function ($row) {
                    return $row->user?->position 
                    ? '<a href="'.route('admin.apps.hr.users.show', $row->user->id).'" target="_blank">'.$row->user->position.'</a>' 
                    : ($row->user?->designation ?? 'N/A');
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'status', 'user']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.achievements.index');
    }

    public function create()
    {
        $html = view('admin.achievements.partials.create')->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreAchievementRequest $request)
    {
        $achievement = new Achievement();
        $achievement->uuid = Str::uuid();
        $achievement->title = $request->title;
        $achievement->slug = $this->slug($request->title);
        $achievement->start_date = $request->start_date;
        $achievement->end_date = $request->end_date;
        $achievement->location = $request->location;
        $achievement->content = $request->content;

        $files = $request->file('achievement_files');

        if ($files) {
            foreach ($files as $file) {
                $achievement->addMedia($file)->toMediaCollection('achievement_files');
            }
        }
        if ($request->user()->achievements()->save($achievement)) {
            return response()->json(['success' => 'Achievement added successfully'], 200);
        }
        return response()->json(['error' => 'There was an error adding the achievement'], 500);
    }

    public function show(Achievement $achievement)
    {
        return response()->json($achievement);
    }

    public function publishSlider(Request $request, Achievement $achievement)
    {
        if ($achievement->status === 'draft') {
            $achievement->published_at = now();
            $achievement->status = 'published';
            $message = 'Achievement has been published successfully.';
        } else {
            $achievement->status = 'draft';
            $message = 'Achievement has been unpublished.';
        }
        $achievement->published_by = $request->user()->id;
        $achievement->save();
        return response()->json(['success' => $message], 200);
    }

    public function archiveSlider(Request $request, Achievement $achievement)
    {
        if (!is_null($achievement->published_at)) {
            $achievement->status = 'archived';
            $achievement->save();
            return response()->json(['success' => 'Achievement has been archived successfully.'], 200);
        }
        return response()->json(['error' => 'Achievement cannot be archived.'], 403);
    }

    public function showDetail(Achievement $achievement)
    {
        if (!$achievement) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Achievement Detail',
                ],
            ]);
        }

        $html = view('admin.achievements.partials.detail', compact('achievement'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Achievement $achievement)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        if (in_array($achievement->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived achievements cannot be updated'], 403);
        }

        $achievement->{$request->field} = $request->value;

        if ($achievement->isDirty($request->field)) {
            $achievement->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function uploadFile(Request $request, Achievement $achievement)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpeg,jpg,png,gif|max:10240', 
        ]);

        if (in_array($achievement->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived achievements cannot be updated'], 403); 
        }

        try {
            $achievement->addMedia($request->file('image'))
                ->toMediaCollection('achievements');
            return response()->json(['success' => 'File uploaded successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Achievement $achievement)
    {
        if ((request()->user()->isAdmin() || ($achievement->status === 'draft' && is_null($achievement->published_at))) && $achievement->delete()) {
            return response()->json(['success' => 'Achievement has been deleted successfully.']);
        }

        return response()->json(['error' => 'Published, Archived, or Draft achievements that were once published cannot be deleted.']);
    }
}
