<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SiteNotification;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreTenderRequest;

class TenderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $tender = Tender::query()->withoutGlobalScope('published');

        $tender->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($tender)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.tenders.partials.buttons', compact('row'))->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.tenders.partials.status', compact('row'))->render();
                })
                ->editColumn('date_of_advertisement', function ($row) {
                    return $row->date_of_advertisement->format('j, F Y');
                })
                ->editColumn('closing_date', function ($row) {
                    return $row->closing_date->format('j, F Y');
                })
                ->editColumn('status', function ($row) {
                    return view('admin.tenders.partials.status', compact('row'))->render();
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
                ->rawColumns(['action', 'status', 'user']);

            // if (!$request->input('search.value') && $request->has('searchBuilder')) {
            //     $dataTable->filter(function ($query) use ($request) {
            //         $sb = new \App\SearchBuilder($request, $query);
            //         $sb->build();
            //     });
            // }

            return $dataTable->toJson();
        }

        return view('admin.tenders.index');
    }

    public function create()
    {
        $stats = [
            'totalCount' => Tender::withoutGlobalScope('published')->count(),
            'publishedCount' => Tender::withoutGlobalScope('published')->where('status', 'published')->whereNotNull('published_at')->count(),
            'archivedCount' => Tender::withoutGlobalScope('published')->where('status', 'archived')->count(),
            'unPublishedCount' => Tender::withoutGlobalScope('published')->where('status', 'draft')->count(),
        ];
        $cat = [
            'tender_domain' => Category::where('type', 'tender_domain')->get(),
        ];
        return view('admin.tenders.create', compact('stats', 'cat'));
    }

    public function store(StoreTenderRequest $request)
    {
        $tender = new Tender();
        $tender->title = $request->title;
        $title = collect(explode(' ', $request->title))->take(5)->join(' ');
        $tender->slug = Str::slug($title) . '-' . substr(uniqid(), -6) . '-' . date('d-m-Y');
        $tender->description = $request->description;
        $tender->procurement_entity = $request->procurement_entity;
        $tender->date_of_advertisement = $request->date_of_advertisement;
        $tender->closing_date = $request->closing_date;
        $tender->domain = $request->tender_domain;
        $tender->user_id = $request->user ?? $request->user()->id;
        $tender->status = 'draft';
        
        $tender_documents = $request->file('tender_documents');
        $tender_eoi_documents = $request->file('tender_eoi_documents');
        $bidding_documents = $request->file('bidding_documents');

        if ($tender_documents) {
            foreach ($tender_documents as $document) {
                $tender->addMedia($document)->toMediaCollection('tender_documents');
            }
        }

        if ($tender_eoi_documents) {
            foreach ($tender_eoi_documents as $document) {
                $tender->addMedia($document)->toMediaCollection('tender_eoi_documents');
            }
        }

        if ($bidding_documents) {
            foreach ($bidding_documents as $document) {
                $tender->addMedia($document)->toMediaCollection('bidding_documents');
            }
        }

        if ($tender->save()) {
            return redirect()->route('admin.tenders.create')->with('success', 'Tender Added successfully');
        }
        return redirect()->route('admin.tenders.create')->with('danger', 'There is an error adding the tender');
    }

    public function show(Tender $tender)
    {
        return response()->json($tender);
    }

    public function publishTender(Request $request, $tenderId)
    {
        $tender = Tender::withoutGlobalScope('published')->findOrFail($tenderId);
        if ($tender->status === 'draft') {
            $tender->published_at = now();
            $tender->status = 'published';
            $message = 'Tender has been published successfully.';
            SiteNotification::create([
                'type' => 'Tender', 
                'title' => $tender->title,
                'url' => route('tenders.show', $tender->slug),
            ]);
        } else {
            $tender->status = 'draft';
            $message = 'Tender has been unpublished.';
        }
        $tender->published_by = $request->user()->id;
        $tender->save();
        return response()->json(['success' => $message], 200);
    }

    public function archiveTender(Request $request, Tender $tender)
    {
        if (!is_null($tender->published_at)) {
            $tender->status = 'archived';
            $tender->save();
            return response()->json(['success' => 'Tender has been archived successfully.'], 200);
        }
        return response()->json(['success' => 'Tender cannot be archived.'], 403);
    }

    public function showDetail($tenderId)
    {
        $tender = Tender::withoutGlobalScope('published')->findOrFail($tenderId);
        if (!$tender) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Tender Detail',
                ],
            ]);
        }

        $cat = [
            'tender_domain' => Category::where('type', 'tender_domain')->get(),
        ];

        $html = view('admin.tenders.partials.detail', compact('tender', 'cat'))->render();
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
            'id'    => 'required|integer|exists:tenders,id',
        ]);

        $tender = Tender::withoutGlobalScope('published')->findOrFail($request->id);

        if (in_array($tender->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived tender cannot be updated'], 403);
        }

        $tender->{$request->field} = $request->value;

        if ($tender->isDirty($request->field)) {
            $tender->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }


    public function uploadFile(Request $request)
    {
        $request->validate([
            'id'   => 'required|integer|exists:tenders,id',
            'attachment' => 'required|file|mimes:pdf,docx,pptx,txt,jpeg,jpg,png,gif|max:10240', 
        ]);

        $tender = Tender::withoutGlobalScope('published')->findOrFail($request->id);

        if (in_array($tender->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived tender cannot be updated'], 403); 
        }

        try {
            $tender->addMedia($request->file('tender_document'))
                ->toMediaCollection('tender_documents');

            return response()->json(['success' => 'File uploaded successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($tenderId)
    {
        $tender = Tender::withoutGlobalScope('published')->findOrFail($tenderId);
        if ($tender->status === 'draft' && is_null($tender->published_at)) {
            if ($tender->delete()) {
                return response()->json(['success' => 'Tender has been deleted successfully.']);
            }
        }
        return response()->json(['error' => 'Published, Archived, or Draft tender that were once published cannot be deleted.']);
    }
}
