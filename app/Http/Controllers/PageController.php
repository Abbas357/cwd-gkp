<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $page = Page::query()->withoutGlobalScope('active');

        $page->when($status !== null, function ($query) use ($status) {
            $query->where('is_active', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($page)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.pages.partials.buttons', compact('row'))->render();
                })
                ->addColumn('attachment', function ($row) {
                    return '<a target="_blank" href="' . $row->getFirstMediaUrl('page_attachments') . '" class="btn btn-light bi bi-file-earmark fs-4"></span>';
                })
                ->editColumn('status', function ($row) {
                    return view('admin.pages.partials.status', compact('row'))->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'status', 'attachment']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.pages.index');
    }

    public function create()
    {
        $cat = [
            'page_type' => Category::where('type', 'page_type')->get(),
        ];
        return view('admin.pages.create', compact('cat'));
    }

    public function store(StorePageRequest $request)
    {
        $page = new Page();
        $page->page_type = $request->page_type;
        $page->title = $request->title;
        $page->content = $request->content;
        $page->slug = Str::slug($request->title);

        if ($request->hasFile('attachment')) {
            $page->addMedia($request->file('attachment'))
                ->toMediaCollection('page_attachments');
        }

        if ($page->save()) {
            return redirect()->route('admin.pages.create')->with('success', 'Page Added successfully');
        }
        return redirect()->route('admin.pages.create')->with('danger', 'There is an error adding the page');
    }

    public function show(Page $page)
    {
        return response()->json($page);
    }

    public function activatePage(Request $request, $pageId)
    {
        $page = Page::withoutGlobalScope('active')->findOrFail($pageId);
        if ($page->is_active === 1) {
            $page->is_active = 0;
            $message = 'Page activated successfully.';
        } else {
            $page->is_active = 1;
            $message = 'Page has been deactivated.';
        }
        $page->save();
        return response()->json(['success' => $message], 200);
    }

    public function showDetail($pageId)
    {
        $page = Page::withoutGlobalScope('active')->findOrFail($pageId);
        if (!$page) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Page Detail',
                ],
            ]);
        }

        $cat = [
            'page_type' => Category::where('type', 'page_type')->get(),
        ];

        $html = view('admin.pages.partials.detail', compact('page', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
            'id'    => 'required|integer|exists:pages,id',
        ]);

        $page = Page::withoutGlobalScope('active')->findOrFail($request->id);

        $page->{$request->field} = $request->value;

        if ($page->isDirty($request->field)) {
            Cache::forget('about_partial');
            $page->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'id'   => 'required|integer|exists:pages,id',
            'attachment' => 'required|file|mimes:pdf,docx,pptx,txt,jpeg,jpg,png,gif|max:10240', 
        ]);

        $page = Page::withoutGlobalScope('active')->findOrFail($request->id);

        if ($page->is_active === 1) {
            return response()->json(['error' => 'Active page cannot be updated'], 403); 
        }

        try {
            $page->addMedia($request->file('attachment'))
                ->toMediaCollection('page_attachments');

            Cache::forget('about_partial');
            return response()->json(['success' => 'Page uploaded successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($pageId)
    {
        $page = Page::withoutGlobalScope('active')->findOrFail($pageId);
        if ($page->is_active === 0 && $page->delete()) {
            Cache::forget('about_partial');
            return response()->json(['success' => 'Page has been deleted successfully.']);
        }
        return response()->json(['error' => 'Active page cannot be deleted.']);
    }
}