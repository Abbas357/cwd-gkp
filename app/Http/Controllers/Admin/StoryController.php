<?php

namespace App\Http\Controllers\Admin;

use App\Models\Story;

use App\Helpers\Database;
use Illuminate\Http\Request;
use App\Helpers\SearchBuilder;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoryRequest;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        $published = $request->query('published');

        $stories = Story::query();

        $stories->when($published !== null, function ($query) use ($published) {
            if ($published === '1') {
                $query->whereNotNull('published_at');
            } else {
                $query->whereNull('published_at');
            }
        });

        $relationMappings = [
            'user' => 'user.currentPosting.designation.name'
        ];

        if ($request->ajax()) {
            $dataTable = Datatables::of($stories)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.stories.partials.buttons', compact('row'))->render();
                })
                ->editColumn('image', function ($row) {
                    $image = $row->getFirstMediaUrl('stories');
                    return view('admin.stories.partials.image', compact('image'))->render();
                })
                ->addColumn('user', function ($row) {
                    return $row->user->currentPosting?->designation->name 
                    ? '<a href="'.route('admin.apps.hr.users.show', $row->user->id).'" target="_blank">'.$row->user->currentPosting?->designation->name .'</a>' 
                    : ($row->user->currentPosting?->designation->name  ?? 'N/A');
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'image', 'user']);

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
        return view('admin.stories.index');
    }

    public function create()
    {
        $html = view('admin.stories.partials.create')->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreStoryRequest $request)
    {
        $story = new Story();
        $story->title = $request->title;

        if ($request->hasFile('image')) {
            $story->addMedia($request->file('image'))
                ->toMediaCollection('stories');
        }
        if ($request->user()->stories()->save($story)) {
            return response()->json(['success' => 'Story added successfully']);
        }

        return response()->json(['error' => 'Error submitting the story']);
    }

    public function publishStory(Request $request, Story $story)
    {
        if (is_null($story->published_at)) {
            $story->published_at = now();
            $message = 'Story has been published successfully.';
        } else {
            $story->published_at = null;
            $message = 'Story has been unpublished.';
        }
        $story->published_by = $request->user()->id;
        $story->save();
        return response()->json(['success' => $message], 200);
    }

    public function show(Story $story)
    {
        return response()->json($story);
    }

    public function destroy(Story $story)
    {
        if ($story->delete()) {
            return response()->json(['success' => 'Story has been deleted successfully.']);
        }
        return response()->json(['error' => 'Story can\'t be deleted.']);
    }
}
