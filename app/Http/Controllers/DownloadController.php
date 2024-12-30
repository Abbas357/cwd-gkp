<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Download;
use Illuminate\Http\Request;
use App\Models\SiteNotification;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreDownloadRequest;

class DownloadController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $downloads = Download::query()->withoutGlobalScope('published');

        $downloads->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($downloads)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.downloads.partials.buttons', compact('row'))->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.downloads.partials.status', compact('row'))->render();
                })
                ->addColumn('file', function ($row) {
                    return '<a target="_blank" href="' . $row->getFirstMediaUrl('downloads') . '" class="btn btn-light bi bi-file-earmark fs-4"></span>';
                })
                ->addColumn('uploaded_by', function ($row) {
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
                ->rawColumns(['action', 'status', 'file', 'uploaded_by']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.downloads.index');
    }

    public function create()
    {
        $stats = [
            'totalCount' => Download::withoutGlobalScope('published')->count(),
            'publishedCount' => Download::withoutGlobalScope('published')->where('status', 'published')->whereNotNull('published_at')->count(),
            'archivedCount' => Download::withoutGlobalScope('published')->where('status', 'archived')->count(),
            'unPublishedCount' => Download::withoutGlobalScope('published')->where('status', 'draft')->count(),
        ];
        $cat = [
            'file_type' => Category::where('type', 'file_type')->get(),
            'download_category' => Category::where('type', 'download_category')->get(),
        ];
        return view('admin.downloads.create', compact('stats', 'cat'));
    }

    public function store(StoreDownloadRequest $request)
    {
        $download = new Download();
        $download->file_name = $request->file_name;
        $download->file_type = $request->file_type;
        $download->category = $request->category;
        $download->status = 'draft';

        if ($request->hasFile('file')) {
            $download->addMedia($request->file('file'))
                ->toMediaCollection('downloads');
        }

        if ($request->user()->downloads()->save($download)) {
            return redirect()->route('admin.downloads.create')->with('success', 'File Added successfully');
        }
        return redirect()->route('admin.downloads.create')->with('danger', 'There is an error adding your download');
    }

    public function show(Download $Download)
    {
        return response()->json($Download);
    }

    public function publishDownload(Request $request, Download $download)
    {
        if ($download->status === 'draft') {
            $download->published_at = now();
            $download->status = 'published';
            $message = 'File has been published successfully.';
        } else {
            $download->status = 'draft';
            $message = 'File has been unpublished.';
        }
        $download->published_by = $request->user()->id;
        $download->save();
        return response()->json(['success' => $message], 200);
    }

    public function archiveDownload(Request $request, Download $download)
    {
        if (!is_null($download->published_at)) {
            $download->status = 'archived';
            $download->save();
            return response()->json(['success' => 'File has been archived successfully.'], 200);
        }
        return response()->json(['success' => 'File cannot be archived.'], 403);
    }

    public function showDetail(Download $download)
    {
        if (!$download) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Download Detail',
                ],
            ]);
        }

        $cat = [
            'file_type' => Category::where('type', 'file_type')->get(),
            'download_category' => Category::where('type', 'download_category')->get(),
        ];

        $html = view('admin.downloads.partials.detail', compact('download', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Download $download)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        if (in_array($download->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived downlods cannot be updated'], 403);
        }

        $download->{$request->field} = $request->value;

        if ($download->isDirty($request->field)) {
            $download->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }


    public function uploadFile(Request $request, Download $download)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,docx,pptx, txt,jpg,png|max:10240', 
        ]);

        if (in_array($download->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived downloads cannot be updated'], 403); 
        }

        try {
            $file = $request->file('file');
            $download->addMedia($file)->toMediaCollection('downloads');

            return response()->json(['success' => 'File uploaded successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }
    }


    public function destroy(Download $download)
    {
        if ($download->status === 'draft' && is_null($download->published_at)) {
            if ($download->delete()) {
                return response()->json(['success' => 'File has been deleted successfully.']);
            }
        }
        return response()->json(['error' => 'Published, Archived, or Draft downloads that were once published cannot be deleted.']);
    }
}
