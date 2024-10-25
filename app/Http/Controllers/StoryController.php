<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Story;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreStoryRequest;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        $published = $request->query('published');

        $stories = Story::query()->latest('id');

        $stories->when($published !== null, function ($query) use ($published) {
            if ($published === '1') {
                $query->whereNotNull('published_at');
            } else {
                $query->whereNull('published_at');
            }
        });

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
                    return $row->user ? $row->user->name . ' (' . $row->user->designation . ' - ' . $row->user->office  . ')' : 'N/A';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'image']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }
        return view('admin.stories.index');
    }

    public function getStories(Request $request)
    {
        $seenUserIds = $request->input('seenUserIds', []);
        // Determine expired users
        $expiredUsers = [];

        if (!empty($seenUserIds)) {
            $usersWithExpiredStories = User::whereIn('id', $seenUserIds)
                ->whereDoesntHave('stories', function ($query) {
                    $query->where('created_at', '>=', now()->subDay());
                })
                ->pluck('id')
                ->toArray();

            $expiredUsers = $usersWithExpiredStories;
        }
        // Fetch stories as before
        $users = User::whereHas('stories', function ($query) {
            $query->where('created_at', '>=', now()->subDay());
        })->with(['stories' => function ($query) {
            $query->whereNotNull('published_at')->where('created_at', '>=', now()->subDay());
        }])->get();

        if ($users->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'result' => 'No stories available.',
                ],
                'expiredUsers' => $expiredUsers,
            ]);
        }

        $storiesData = [];

        foreach ($users as $user) {
            $items = [];

            foreach ($user->stories as $story) {
                $items[] = [
                    'id'       => $story->id,
                    'type'     => 'photo',
                    'length'   => 5,
                    'src'      => $story->getFirstMediaUrl('stories'),
                    'preview'  => $story->getFirstMediaUrl('stories', 'thumb'),
                    'link'     => 'javascript:void(false)',
                    'linkText' => $story->title . ' <div class=story-views-count>Views: ' . ' ' . $story->views . '</div>',
                    'time'     => $story->created_at->timestamp,
                ];
            }

            $storiesData[] = [
                'id'          => $user->id,
                'photo'       => getProfilePic($user),
                'name'        => $user->designation,
                'link'        => null,
                'lastUpdated' => $user->stories->max('created_at')->timestamp,
                'items'       => $items,
            ];
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'result' => $storiesData,
            ],
            'expiredUsers' => $expiredUsers,
        ]);
    }

    public function create()
    {
        return view('admin.stories.create');
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
            return redirect()->route('admin.stories.create')->with('success', 'Story added successfully');
        }

        return redirect()->route('admin.stories.create')->with('danger', 'Error submitting the story');
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

    public function incrementSeen($userId)
    {
        $stories = User::find($userId)->stories;

        foreach ($stories as $story) {
            if ($story->created_at >= Carbon::now()->subHours(24)) {
                $story->views += 1;

                if (!$story->save()) {
                    return response()->json(['success' => 'false'], 500);
                }
            }
        }
        return response()->json(['success' => 'true', 200]);
    }
}
