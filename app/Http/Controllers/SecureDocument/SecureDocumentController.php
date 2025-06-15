<?php

namespace App\Http\Controllers\SecureDocument;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SecureDocument;
use Yajra\DataTables\DataTables;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;

class SecureDocumentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $documents = SecureDocument::query();

        $documents->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($documents)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.documents.partials.buttons', compact('row'))->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at?->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('modules.documents.index');
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

    public function showDetail($id)
    {
        $document = SecureDocument::find($id);
        if (!$document) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load document detail',
                ],
            ]);
        }
        $html = view('modules.documents.partials.detail', compact('document'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function showCard($id)
    {
        $document = SecureDocument::find($id);
        $data = route('documents.approved', ['uuid' => $document->uuid]);
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(1)
            ->build();

        $qrCodeUri = $qrCode->getDataUri();

        $html = view('modules.documents.partials.qrcode', compact('qrCodeUri'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function publishDocument(Request $request, SecureDocument $document)
    {
        if ($document->status === 'draft') {
            $document->published_at = now();
            $document->status = 'published';
            $message = 'Document has been published successfully.';
        } else {
            $document->status = 'draft';
            $message = 'Document has been unpublished.';
        }
        $document->published_by = $request->user()->id;
        $document->save();
        return response()->json(['success' => $message], 200);
    }

    public function archiveDocument(Request $request, SecureDocument $document)
    {
        if (!is_null($document->published_at)) {
            $document->status = 'archived';
            $document->save();
            return response()->json(['success' => 'Document has been archived successfully.'], 200);
        }
        return response()->json(['success' => 'Document cannot be archived.'], 403);
    }

    public function updateField(Request $request, SecureDocument $document)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        if($document->status !== 'draft') {
            return response()->json(['error' => 'Published or Archived document cannot be updated']);
        }
        $document->{$request->field} = $request->value;
        $document->save();

        return response()->json(['success' => 'Field saved']);
    }

    public function destroy(SecureDocument $document)
    {
        if (($document->status === 'draft' && is_null($document->published_at)) && $document->delete()) {
            return response()->json(['success' => 'Document has been deleted successfully.']);
        }

        return response()->json(['error' => 'Published, Archived, or Draft document that were once published cannot be deleted.']);
    }
}
