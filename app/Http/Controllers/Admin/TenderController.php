<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;

use App\Models\Tender;
use App\Helpers\Database;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\SearchBuilder;
use App\Models\SiteNotification;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
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

        $relationMappings = [
            'user' => 'user.currentPosting.designation.name'
        ];

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
                    return $row->user?->currentPosting?->designation?->name
                        ? '<a href="' . route('admin.apps.hr.users.show', $row?->user?->id) . '" target="_blank">' . $row->user?->currentPosting?->designation?->name . '</a>'
                        : ($row->user?->currentPosting?->designation?->name  ?? 'N/A');
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'status', 'user']);

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
        try {
            $this->validateFileUploads($request);

            $name = data_get(User::find($request->user), 'currentPosting.office.name');

            $tender = new Tender();
            $tender->title = $request->title . ' (' . $name . ')';
            $tender->slug = Str::uuid();
            $tender->description = $request->description;
            $tender->date_of_advertisement = $request->date_of_advertisement;
            $tender->closing_date = $request->closing_date;
            $tender->user_id = $request->user ?? 0;

            // Save tender first to get the ID
            if (!$tender->save()) {
                return response()->json(['error' => 'Failed to save tender data.'], 500);
            }

            $this->handleFileUploads($tender, $request);

            return response()->json(['success' => 'Tender added successfully.']);
        } catch (\Exception $e) {
            Log::error('Tender creation failed: ' . $e->getMessage(), [
                'user_id' => $request->user,
                'title' => $request->title,
                'error' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'There was an error adding the tender: ' . $e->getMessage()
            ], 500);
        }
    }

    private function validateFileUploads($request)
    {
        $fileFields = ['tender_documents', 'tender_eoi_documents', 'bidding_documents'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $files = $request->file($field);
                foreach ($files as $file) {
                    if (!$file->isValid()) {
                        throw new \Exception("Invalid file upload for {$field}: " . $file->getErrorMessage());
                    }

                    if ($file->getSize() > 10 * 1024 * 1024) { // 10MB
                        throw new \Exception("File too large for {$field}: " . $file->getClientOriginalName());
                    }

                    $allowedMimes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                    if (!in_array($file->getMimeType(), $allowedMimes)) {
                        throw new \Exception("Invalid file type for {$field}: " . $file->getClientOriginalName());
                    }
                }
            }
        }
    }

    private function handleFileUploads($tender, $request)
    {
        $fileCollections = [
            'tender_documents' => 'tender_documents',
            'tender_eoi_documents' => 'tender_eoi_documents',
            'bidding_documents' => 'bidding_documents'
        ];

        foreach ($fileCollections as $requestField => $collection) {
            if ($request->hasFile($requestField)) {
                $files = $request->file($requestField);
                foreach ($files as $document) {
                    try {
                        $tender->addMedia($document)
                            ->usingName($document->getClientOriginalName())
                            ->toMediaCollection($collection);
                    } catch (\Exception $e) {
                        Log::error("Failed to upload file {$document->getClientOriginalName()}: " . $e->getMessage());
                        throw new \Exception("Failed to upload file: " . $document->getClientOriginalName());
                    }
                }
            }
        }
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

        $html = view('admin.tenders.partials.detail', compact('tender'))->render();
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
