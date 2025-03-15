<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Comment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

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
                ->editColumn('name', function ($row) {
                    return $row->name ?? '<span class="badge bg-info">'. $row->user->name .'</span>';
                })
                ->editColumn('email', function ($row) {
                    return $row->email ?? '<span class="badge bg-info">'. $row->user->email .'</span>';
                })
                ->editColumn('status', function ($row) {
                    return view('admin.comments.partials.status', compact('row'))->render();
                })
                ->addColumn('published_by', function ($row) {
                    return $row->publishBy?->currentPosting?->designation->name 
                        ? '<a href="' . route('admin.apps.hr.users.show', $row->publishBy->id) . '" target="_blank">' . $row->publishBy?->currentPosting?->designation->name . '</a>'
                        : ($row->publishBy?->currentPosting?->designation->name ?? 'N/A');
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'status', 'published_by', 'name', 'email']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.comments.index');
    }

    public function showDetail(Comment $comment)
    {
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

    public function publishComment(Request $request, Comment $comment)
    {
        if ($comment->status === 'draft') {
            $comment->published_at = now();
            $comment->status = 'published';
            $message = 'Comment has been published successfully.';
        } else {
            $comment->status = 'draft';
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

    public function destroy(Comment $comment)
    {
        if (request()->user()->isAdmin() || ($comment->status === 'new' && is_null($comment->published_at))) {
            if ($comment->delete()) {
                return response()->json(['success' => 'File has been deleted successfully.']);
            }
        }
        return response()->json(['error' => 'Published, Archived, or Draft comment that were once published cannot be deleted.']);
    }

    public function response(Request $request, Comment $comment)
    {
        $responseComment = Comment::create([
            'body' => $request->reply,
            'commentable_type' => $comment->commentable_type,
            'commentable_id' => $comment->commentable_id,
            'status' => 'published',
            'published_by' => Auth::id(),
            'published_at' => now(),
            'parent_id' => $comment->id,
            'user_id' => Auth::id(),
        ]);

        if ($responseComment) {
            return response()->json(['success' => 'Response posted successfully.']);
        }

        return response()->json(['error' => 'Unable to post response.'], 500);
    }

    public function getResponseView(Comment $Comment)
    {
        if (!$Comment) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Comment Detail',
                ],
            ]);
        }
        $html = view('admin.comments.partials.add', compact('Comment'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function postResponse(Request $request) 
    {
        $responseComment = Comment::create([
            'body' => $request->body,
            'commentable_type' => $request->commentable_type,
            'commentable_id' => $request->commentable_id,
            'status' => 'published',
            'published_by' => Auth::id(),
            'published_at' => now(),
            'parent_id' => $request->parent_id ?? null,
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('attachment')) {
            $responseComment->addMedia($request->file('attachment'))
                ->toMediaCollection('comment_attachments');
        }

        if ($responseComment) {    
            if ($request->wantsJson()) {
                return response()->json(['success' =>  'Comment added successfully']);
            }
    
            return redirect()->route('admin.news.index')->with(['success' => 'Comment added successfully']);
        }
        
        if ($request->wantsJson()) {
            return response()->json(['error' => 'Failed to add the comment.']);
        }
    
        return redirect()->route('admin.news.index')->with(['error' => 'Failed to add the comment.']);
    }
}
