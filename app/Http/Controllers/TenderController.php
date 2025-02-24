<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SiteNotification;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Route;
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

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.tenders.index');
    }

    public function create()
    {
        $html = view('admin.tenders.partials.create')->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreTenderRequest $request)
    {
        $tender = new Tender();
        $tender->title = $request->title;
        $tender->slug = Str::uuid();
        $tender->description = $request->description;
        $tender->date_of_advertisement = $request->date_of_advertisement;
        $tender->closing_date = $request->closing_date;
        $tender->user_id = $request->user ?? $request->user()->id;
        
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
            return response()->json(['success' => 'Tender added successfully.']);
        }

        return response()->json(['error' => 'There was an error adding the tender.']);
    }

    public function show(Tender $tender)
    {
        return response()->json($tender);
    }

    public function publishTender(Request $request, Tender $tender)
    {
        if ($tender->status === 'draft') {
            $tender->published_at = now();
            $tender->status = 'published';
            $message = 'Tender has been published successfully.';
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

    public function showDetail(Tender $tender)
    {
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

    public function updateField(Request $request, Tender $tender)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

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

    public function destroy(Tender $tender)
    {
        if ((request()->user()->isAdmin() || ($tender->status === 'draft' && is_null($tender->published_at))) && $tender->delete()) {
            return response()->json(['success' => 'Tender has been deleted successfully.']);
        }

        return response()->json(['error' => 'Published, Archived, or Draft tender that were once published cannot be deleted.']);
    }

    public function updateComments(Request $request, Tender $tender)
    {
        $validated = $request->validate([
            'comments_allowed' => 'required|boolean',
        ]);

        $tender->update($validated);

        return response()->json([
            'success' => 'Comments visibility updated',
        ]);
    }
}
