<?php

namespace App\Http\Controllers\SecureDocument;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SecureDocument;
use Yajra\DataTables\DataTables;
use Endroid\QrCode\Builder\Builder;
use App\Http\Controllers\Controller;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Auth;
use Endroid\QrCode\Encoding\Encoding;
use App\Http\Requests\StoreSecureDocumentRequest;

class SecureDocumentController extends Controller
{
    protected $cat = [
        'document_type' => ['letter', 'notification', 'report', 'seniority_list', 'merit_list', 'invoice', 'memo', 'contract', 'policy']
    ];

    public function index(Request $request)
    {
        $user = request()->user();
        $documents = SecureDocument::query()
        ->when(!$user->isAdmin(), function ($query) use ($user) {
            return $query->where('posting_id', $user->currentPosting->id);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($documents)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.secure_documents.partials.buttons', compact('row'))->render();
                })
                ->editColumn('issue_date', function ($row) {
                    return $row->issue_date?->format('j, F Y');
                })
                ->addColumn('officer', function ($row) {
                    return $row->posting->office->name;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at?->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'description']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('modules.secure_documents.index');
    }

    public function create()
    {
        $cat = $this->cat;
        $html = view('modules.secure_documents.partials.create', compact('cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreSecureDocumentRequest $request)
    {
        $document = new SecureDocument();
        $document->uuid = Str::uuid();
        $document->document_type = $request->document_type;
        $document->title = $request->title;
        $document->description = $request->description;
        $document->document_number = $request->document_number;
        $document->issue_date = $request->issue_date;
        $document->posting_id = $request->user()->currentPosting->id;

        if ($request->hasFile('attachment')) {
            $document->addMedia($request->file('attachment'))
                ->toMediaCollection('secure_document_attachments');
        }

        if (!$document->save()) {
            return response()->json(['error' => 'Failed to save document.'], 500);
        }
        return response()->json(['success' => 'Document added successfully.']);
    }

    public function show(SecureDocument $document)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $document,
            ],
        ]);
    }

    public function showDetail(SecureDocument $document)
    {
        $cat = $this->cat;
        if (!$document) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load document detail',
                ],
            ]);
        }
        $html = view('modules.secure_documents.partials.detail', compact('document', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function viewQR(SecureDocument $document)
    {
        $data = route('documents.approved', ['uuid' => $document->uuid]);
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(1)
            ->build();

        $qrCodeUri = $qrCode->getDataUri();

        $html = view('modules.secure_documents.partials.qrcode', compact('qrCodeUri'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function approved($uuid)
    {
        $document = SecureDocument::where('uuid', $uuid)->first();
        return view('site.secure_documents.approved', compact('document'));
    }

    public function updateField(Request $request, SecureDocument $document)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $document->{$request->field} = $request->value;
        $document->save();

        return response()->json(['success' => 'Field saved']);
    }

    public function uploadFile(Request $request, SecureDocument $document)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:pdf,jpeg,jpg,png,gif|max:10240', 
        ]);

        try {
            $document->addMedia($request->file('attachment'))
                ->toMediaCollection('secure_document_attachments');
            return response()->json(['success' => 'File uploaded successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading file: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(SecureDocument $document)
    {
        if ($document->delete()) {
            return response()->json(['success' => 'Document has been deleted successfully.']);
        }

        return response()->json(['error' => 'Document cannot be deleted.']);
    }
}
