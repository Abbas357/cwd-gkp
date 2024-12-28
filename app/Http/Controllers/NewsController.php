<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SiteNotification;
use Yajra\DataTables\DataTables;
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
                    return $row->user?->position 
                    ? '<a href="'.route('admin.users.show', $row->user->id).'" target="_blank">'.$row->user->position.'</a>' 
                    : ($row->user?->designation ?? 'N/A');
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'status', 'attachment', 'user']);

            // if (!$request->input('search.value') && $request->has('searchBuilder')) {
            //     $dataTable->filter(function ($query) use ($request) {
            //         $sb = new \App\SearchBuilder($request, $query);
            //         $sb->build();
            //     });
            // }

            return $dataTable->toJson();
        }

        return view('admin.news.index');
    }

    public function create()
    {
        $stats = [
            'totalCount' => News::withoutGlobalScope('published')->count(),
            'publishedCount' => News::withoutGlobalScope('published')->where('status', 'published')->whereNotNull('published_at')->count(),
            'archivedCount' => News::withoutGlobalScope('published')->where('status', 'archived')->count(),
            'unPublishedCount' => News::withoutGlobalScope('published')->where('status', 'draft')->count(),
        ];
        $cat = [
            'news_category' => Category::where('type', 'news_category')->get(),
        ];
        return view('admin.news.create', compact('stats', 'cat'));
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
            return redirect()->route('admin.news.create')->with('success', 'News Added successfully');
        }
        return redirect()->route('admin.news.create')->with('danger', 'There is an error adding the news');
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

        $cat = [
            'news_category' => Category::where('type', 'news_category')->get(),
        ];

        $html = view('admin.news.partials.detail', compact('news', 'cat'))->render();
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
        if ($news->status === 'draft' && is_null($news->published_at)) {
            if ($news->delete()) {
                return response()->json(['success' => 'File has been deleted successfully.']);
            }
        }
        return response()->json(['error' => 'Published, Archived, or Draft news that were once published cannot be deleted.']);
    }
}
