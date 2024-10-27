<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EStandardization;
use Yajra\DataTables\DataTables;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\Encoding\Encoding;
use App\Mail\StandardizationApprovedMail;
use App\Mail\StandardizationRejectedMail;

class EStandardizationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $standardizations = EStandardization::query()->latest('id');

        $standardizations->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($standardizations)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.standardizations.partials.buttons', compact('row'))->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->diffForHumans();
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->editColumn('status', function ($row) {
                    return $row->status === 1 ? 'Approved' : 'Not Approved';
                })
                ->rawColumns(['action']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.standardizations.index');
    }

    public function show(EStandardization $EStandardization)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $EStandardization,
            ],
        ]);
    }

    public function showDetail(EStandardization $EStandardization)
    {
        if (!$EStandardization) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Product detail',
                ],
            ]);
        }
        $html = view('admin.standardizations.partials.detail', compact('EStandardization'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function showCard(EStandardization $EStandardization)
    {
        if ($EStandardization->status !== 1) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'The Product is not standardized',
                ],
            ]);
        }
        $data = route('standardizations.approved', ['id' => $EStandardization->id]);
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(1)
            ->build();

        $qrCodeUri = $qrCode->getDataUri();

        $html = view('admin.standardizations.partials.card', compact('EStandardization', 'qrCodeUri'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function approve(Request $request, EStandardization $EStandardization)
    {
        if ($EStandardization->status !== 1) {
            $EStandardization->status = 1;
            if($EStandardization->save()) {
                Mail::to($EStandardization->email)->queue(new StandardizationApprovedMail($EStandardization));
                return response()->json(['success' => 'Product has been approved successfully.']);
            }
        }
        return response()->json(['error' => 'Product can\'t be approved.']);
    }

    public function reject(Request $request, EStandardization $EStandardization)
    {
        if (!in_array($EStandardization->status, [1, 2])) {
            $EStandardization->status = 2;
            $EStandardization->rejection_reason = $request->reason;

            if($EStandardization->save()) {
                Mail::to($EStandardization->email)->queue(new StandardizationRejectedMail($EStandardization, $$request->reason));
                return response()->json(['success' => 'Product has been rejected.']);
            }
        }
        return response()->json(['error' => 'Product can\'t be rejected.']);
    }

    public function updateField(Request $request)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $EStandardization = EStandardization::find($request->id);
        if($EStandardization->status !== 0) {
            return response()->json(['error' => 'Approved or Rejected Products cannot be updated']);
        }
        $EStandardization->{$request->field} = $request->value;
        $EStandardization->save();

        return response()->json(['success' => 'Field saved']);
    }

    public function uploadFile(Request $request)
    {
        $standardization = EStandardization::find($request->id);
        if($standardization->status !== 0) {
            return response()->json(['error' => 'Approved or Rejected Products cannot be updated']);
        }
        $file = $request->file;
        $collection = $request->collection;
        $standardization->addMedia($file)->toMediaCollection($collection);
        if($standardization->save()) {
            return response()->json(['success' => 'File Updated']);
        }
        return response()->json(['error' => 'Error Uploading File']);
    }
}
