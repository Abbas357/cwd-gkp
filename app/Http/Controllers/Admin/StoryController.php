<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Story;
use App\Http\Requests\StoreStoryRequest;
use App\Http\Requests\UpdateStoryRequest;

class StoryController extends Controller
{
    
    public function index()
    {
        
    }

    public function getStories()
    {
        $stories = Story::all();

        if (!$stories) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load stories.',
                ],
            ]);
        }

        $html = view('partials.stories-content', compact('stories'))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
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
        $story->description = $request->description;

        if ($request->hasFile('image')) {
            $story->addMedia($request->file('image'))
                ->toMediaCollection('stories');
        }
        if ($story->save()) {
            return redirect()->route('admin.stories.create')->with('success', 'Story added successfully');
        }

        return redirect()->route('admin.stories.create')->with('danger', 'Error submitting the story');
    }

    public function show(Story $story)
    {
        
    }
    
    public function edit(Story $story)
    {
        
    }

    public function update(UpdateStoryRequest $request, Story $story)
    {
        
    }

    public function destroy(Story $story)
    {
        
    }
}
