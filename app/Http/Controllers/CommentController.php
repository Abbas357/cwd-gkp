<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $comment = Comment::query()->withoutGlobalScope('published');

        $comment->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($comment)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.comments.partials.buttons', compact('row'))->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.comments.partials.status', compact('row'))->render();
                })
                ->addColumn('published_by', function ($row) {
                    return $row->publishBy?->position
                    ? '<a href="'.route('admin.users.show', $row->publishBy->id).'" target="_blank">'.$row->publishBy->position.'</a>' 
                    : ($row->publishBy?->designation ?? 'N/A');
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'status', 'published_by']);

            // if (!$request->input('search.value') && $request->has('searchBuilder')) {
            //     $dataTable->filter(function ($query) use ($request) {
            //         $sb = new \App\SearchBuilder($request, $query);
            //         $sb->build();
            //     });
            // }

            return $dataTable->toJson();
        }

        return view('admin.comments.index');
    }

    public function showDetail($commentId)
    {
        $comment = Comment::withoutGlobalScope('published')->findOrFail($commentId);
        if (!$comment) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Comment Detail',
                ],
            ]);
        }
        $html = view('admin.comments.partials.detail', compact('comment'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function publishComment(Request $request, $commentId)
    {
        $comment = Comment::withoutGlobalScope('published')->findOrFail($commentId);
        if ($comment->status === 'new') {
            $comment->published_at = now();
            $comment->status = 'published';
            $message = 'Comment has been published successfully.';
        } else {
            $comment->status = 'new';
            $message = 'Comment has been unpublished.';
        }
        $comment->published_by = $request->user()->id;
        $comment->save();
        return response()->json(['success' => $message], 200);
    }

    public function archiveComment(Request $request, Comment $comment)
    {
        if (!is_null($comment->published_at)) {
            $comment->status = 'archived';
            $comment->save();
            return response()->json(['success' => 'Comment has been archived successfully.'], 200);
        }
        return response()->json(['success' => 'Comment cannot be archived.'], 403);
    }

    public function destroy($commentId)
    {
        $comment = Comment::withoutGlobalScope('published')->findOrFail($commentId);
        if ($comment->status === 'new' && is_null($comment->published_at)) {
            if ($comment->delete()) {
                return response()->json(['success' => 'File has been deleted successfully.']);
            }
        }
        return response()->json(['error' => 'Published, Archived, or Draft comment that were once published cannot be deleted.']);
    }
}