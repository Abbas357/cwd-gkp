<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Cache;
use App\Models\Seniority;
use App\Http\Requests\StoreSeniorityRequest;

class SeniorityController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $seniority = Seniority::query()->withoutGlobalScope('published');

        $seniority->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($seniority)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.seniority.partials.buttons', compact('row'))->render();
                })
                ->addColumn('attachment', function ($row) {
                    return '<a target="_blank" href="' . $row->getFirstMediaUrl('seniorities') . '" class="btn btn-light bi bi-file-earmark fs-4"></span>';
                })
                ->editColumn('status', function ($row) {
                    return view('admin.seniority.partials.status', compact('row'))->render();
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
                ->rawColumns(['action', 'status', 'attachment']);

            // if (!$request->input('search.value') && $request->has('searchBuilder')) {
            //     $dataTable->filter(function ($query) use ($request) {
            //         $sb = new \App\SearchBuilder($request, $query);
            //         $sb->build();
            //     });
            // }

            return $dataTable->toJson();
        }

        return view('admin.seniority.index');
    }

    public function create()
    {
        $bps = [];
        for ($i = 1; $i <= 22; $i++) {
            $bps[] = sprintf("BPS-%02d", $i);
        }
        $stats = [
            'totalCount' => Seniority::withoutGlobalScope('published')->count(),
            'publishedCount' => Seniority::withoutGlobalScope('published')->where('status', 'published')->whereNotNull('published_at')->count(),
            'archivedCount' => Seniority::withoutGlobalScope('published')->where('status', 'archived')->count(),
            'unPublishedCount' => Seniority::withoutGlobalScope('published')->where('status', 'draft')->count(),
        ];
        $cat = [
            'designations' => Category::where('type', 'designation')->get(),
            'bps' => $bps,
        ];
        return view('admin.seniority.create', compact('cat', 'stats'));
    }

    public function store(StoreSeniorityRequest $request)
    {
        $seniority = new Seniority();
        $seniority->title = $request->title;
        $seniority->designation = $request->designation;
        $seniority->bps = $request->bps;
        $seniority->seniority_date = $request->seniority_date;
        $seniority->slug = Str::slug($request->title) . '-' . substr(uniqid(), -6). '-' . date('d-m-Y');
        $seniority->status = 'draft';

        if ($request->hasFile('attachment')) {
            $seniority->addMedia($request->file('attachment'))
                ->toMediaCollection('seniorities');
        }

        if ($request->user()->seniority()->save($seniority)) {
            return redirect()->route('admin.seniority.create')->with('success', 'Seniority Added successfully');
        }

        return redirect()->route('admin.seniority.create')->with('error', 'There is an error adding the Seniority');
    }

    public function show(Seniority $seniority)
    {
        return response()->json($seniority);
    }

    public function publishSeniority(Request $request, $seniorityId)
    {
        $seniority = Seniority::withoutGlobalScope('published')->findOrFail($seniorityId);
        if ($seniority->status === 'draft') {
            $seniority->published_at = now();
            $seniority->status = 'published';
            $message = 'Seniority has been published successfully.';
        } else {
            $seniority->status = 'draft';
            $message = 'Seniority has been unpublished.';
        }
        $seniority->published_by = $request->user()->id;
        $seniority->save();
        return response()->json(['success' => $message], 200);
    }

    public function archiveSeniority(Request $request, Seniority $seniority)
    {
        if (!is_null($seniority->published_at)) {
            $seniority->status = 'archived';
            $seniority->save();
            return response()->json(['success' => 'Seniority has been archived successfully.'], 200);
        }
        return response()->json(['success' => 'Seniority cannot be archived.'], 403);
    }

    public function showDetail($seniorityId)
    {
        $seniority = Seniority::withoutGlobalScope('published')->findOrFail($seniorityId);
        if (!$seniority) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Seniority Detail',
                ],
            ]);
        }

        $bps = [];
        for ($i = 1; $i <= 22; $i++) {
            $bps[] = sprintf("BPS-%02d", $i);
        }

        $cat = [
            'designations' => Category::where('type', 'designation')->get(),
            'bps' => $bps,
        ];

        $html = view('admin.seniority.partials.detail', compact('seniority', 'cat'))->render();
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
            'id'    => 'required|integer|exists:seniorities,id',
        ]);

        $seniority = Seniority::withoutGlobalScope('published')->findOrFail($request->id);

        if (in_array($seniority->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived seniority cannot be updated'], 403);
        }

        $seniority->{$request->field} = $request->value;

        if ($seniority->isDirty($request->field)) {
            $seniority->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }


    public function uploadFile(Request $request)
    {
        $request->validate([
            'id'   => 'required|integer|exists:seniorities,id',
            'attachment' => 'required|file|mimes:pdf,docx,pptx,txt,jpeg,jpg,png,gif|max:10240', 
        ]);

        $seniority = Seniority::withoutGlobalScope('published')->findOrFail($request->id);

        if (in_array($seniority->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived seniority cannot be updated'], 403); 
        }

        try {
            $seniority->addMedia($request->file('attachment'))
                ->toMediaCollection('seniorities');

            return response()->json(['success' => 'File uploaded successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($seniorityId)
    {
        $seniority = Seniority::withoutGlobalScope('published')->findOrFail($seniorityId);
        if ($seniority->status === 'draft' && is_null($seniority->published_at)) {
            if ($seniority->delete()) {
                return response()->json(['success' => 'File has been deleted successfully.']);
            }
        }
        return response()->json(['error' => 'Published, Archived, or Draft seniority that were once published cannot be deleted.']);
    }
}
