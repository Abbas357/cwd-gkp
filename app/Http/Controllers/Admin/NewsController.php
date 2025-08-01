<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;

use App\Helpers\Database;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\SearchBuilder;
use App\Models\SiteNotification;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $news = News::query()->withoutGlobalScope('published');

        $news->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        $relationMappings = [
            'user' => 'user.currentPosting.designation.name'
        ];

        if ($request->ajax()) {
            $dataTable = Datatables::of($news)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.news.partials.buttons', compact('row'))->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.news.partials.status', compact('row'))->render();
                })
                ->addColumn('attachment', function ($row) {
                    return '<a target="_blank" href="' . $row->getFirstMediaUrl('news_attachments') . '" class="btn btn-light bi bi-file-earmark fs-4"></span>';
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
                ->rawColumns(['action', 'status', 'attachment', 'user']);

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

        return view('admin.news.index');
    }

    public function create()
    {
        $html = view('admin.news.partials.create')->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreNewsRequest $request)
    {
        $news = new News();
        $news->title = $request->title;
        $news->slug = $this->slug($request->title);
        $news->category = $request->news_category;
        $news->summary = $request->summary;
        $news->content = $request->content;
        $news->status = 'draft';
        
        if ($request->hasFile('attachment')) {
            $news->addMedia($request->file('attachment'))
                ->toMediaCollection('news_attachments');
        }

        if ($request->user()->news()->save($news)) {
            return response()->json(['success' => 'News Added successfully'], 200);
        }
        return response()->json(['error' => 'There is an error adding the news'], 500);
    }

    public function show(News $news)
    {
        return response()->json($news);
    }

    public function publishNews(Request $request, News $news)
    {
        if ($news->status === 'draft') {
            $news->published_at = now();
            $news->status = 'published';
            $message = 'News has been published successfully.';
        } else {
            $news->status = 'draft';
            $message = 'News has been unpublished.';
        }
        $news->published_by = $request->user()->id;
        $news->save();
        return response()->json(['success' => $message], 200);
    }

    public function archiveNews(Request $request, News $news)
    {
        if (!is_null($news->published_at)) {
            $news->status = 'archived';
            $news->save();
            return response()->json(['success' => 'News has been archived successfully.'], 200);
        }
        return response()->json(['success' => 'News cannot be archived.'], 403);
    }

    public function showDetail(News $news)
    {
        if (!$news) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load News Detail',
                ],
            ]);
        }

        $html = view('admin.news.partials.detail', compact('news'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, News $news)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        if (in_array($news->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived news cannot be updated'], 403);
        }

        $news->{$request->field} = $request->value;

        if ($news->isDirty($request->field)) {
            $news->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function uploadFile(Request $request, News $news)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:pdf,docx,pptx,txt,jpeg,jpg,png,gif|max:10240', 
        ]);

        if (in_array($news->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived news cannot be updated'], 403); 
        }

        try {
            $news->addMedia($request->file('attachment'))
                ->toMediaCollection('news_attachments');

            return response()->json(['success' => 'File uploaded successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(News $news)
    {
        if ((auth_user()->isAdmin() || ($news->status === 'draft' && is_null($news->published_at))) && $news->delete()) {
            return response()->json(['success' => 'File has been deleted successfully.']);
        }

        return response()->json(['error' => 'Published, Archived, or Draft news that were once published cannot be deleted.']);
    }

    public function updateComments(Request $request, News $News)
    {
        $validated = $request->validate([
            'comments_allowed' => 'required|boolean',
        ]);

        $News->update($validated);

        return response()->json([
            'success' => 'Comments visibility updated',
        ]);
    }
}
