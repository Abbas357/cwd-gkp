<?php

namespace App\Http\Controllers\Site;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, $type, $id)
    {
        $class = "App\\Models\\$type";

        if (!class_exists($class)) {
            return response()->json(['message' => 'Invalid model type'], 400);
        }

        $model = $class::findOrFail($id);

        $model->addComment([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'body' => $request->input('body'),
            'parent_id' => $request->input('parent_id'),
        ]);

        return redirect()->back()->with(['success' => 'Comment added successfully, it will be visible after moderation. Thank you!']);
    }
}
