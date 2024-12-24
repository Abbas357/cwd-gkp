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

        $ipAddress = request()->ip();
        $sessionKey = "comment_{$type}_{$id}_" . md5($ipAddress);

        if (session()->has($sessionKey)) {
            return redirect()->back()->with(['error' => 'Nope! You have already posted a comment for this item. Sorry']);
        }

        $model->addComment([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'body' => $request->input('body'),
            'parent_id' => $request->input('parent_id'),
        ]);

        session()->put($sessionKey, true);

        return redirect()->back()->with(['success' => 'Your comment is under review and will be visible after moderation. You’ll be notified upon publication. Thank you!']);
    }
}
