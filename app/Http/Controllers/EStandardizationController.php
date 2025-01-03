<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\EStandardization;

use Yajra\DataTables\DataTables;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\Encoding\Encoding;
use App\Mail\Standardization\RenewedMail;
use App\Mail\Standardization\ApprovedMail;
use App\Mail\Standardization\RejectedMail;

class EStandardizationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $standardizations = EStandardization::query();

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
        if ($EStandardization->status !== 'approved') {
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
        if ($EStandardization->status !== 'approved') {
            $EStandardization->status = 'approved';
            $EStandardization->card_issue_date = Carbon::now();
            $EStandardization->card_expiry_date = Carbon::now()->addYears(3);
            if($EStandardization->save()) {
                Mail::to($EStandardization->email)->queue(new ApprovedMail($EStandardization));
                return response()->json(['success' => 'Product has been approved successfully.']);
            }
        }
        return response()->json(['error' => 'Product can\'t be approved.']);
    }

    public function renew(Request $request, EStandardization $EStandardization)
    {
        $currentDate = Carbon::now();

        if ($EStandardization->status === 'approved') {
            if ($currentDate->greaterThanOrEqualTo($EStandardization->card_expiry_date)) {
                $EStandardization->card_issue_date = $request->issue_date ?? $currentDate;
                $EStandardization->card_expiry_date = Carbon::parse($EStandardization->card_issue_date)->addYears(3);

                if ($EStandardization->save()) {
                    Mail::to($EStandardization->email)->queue(new RenewedMail($EStandardization));
                    return response()->json(['success' => 'Card has been renewed successfully.']);
                } else {
                    return response()->json(['error' => 'An error occurred while saving the card data. Please try again.']);
                }
            } else {
                return response()->json(['error' => 'Card cannot be renewed because it has not yet expired.']);
            }
        } else {
            return response()->json(['error' => 'Card status does not allow renewal.']);
        }
    }

    public function reject(Request $request, EStandardization $EStandardization)
    {
        if (!in_array($EStandardization->status, ['approved', 'rejected'])) {
            $EStandardization->status = 'rejected';
            $EStandardization->rejection_reason = $request->reason;

            if($EStandardization->save()) {
                Mail::to($EStandardization->email)->queue(new RejectedMail($EStandardization, $request->reason));
                return response()->json(['success' => 'Product has been rejected.']);
            }
        }
        return response()->json(['error' => 'Product can\'t be rejected.']);
    }

    public function updateField(Request $request, EStandardization $EStandardization)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        if(($request->has('expiry_date') || $request->has('issue_date')) && $EStandardization->status !== 'new') {
            return response()->json(['error' => 'Approved or Rejected Products cannot be updated']);
        }
        $EStandardization->{$request->field} = $request->value;
        $EStandardization->save();

        return response()->json(['success' => 'Field saved']);
    }

    public function uploadFile(Request $request, EStandardization $EStandardization)
    {
        if($request->hasFile('firm_pictures') && $EStandardization->status !== 'new') {
            return response()->json(['error' => 'Approved or Rejected Products cannot be updated']);
        }
        $file = $request->file;
        $collection = $request->collection;
        $EStandardization->addMedia($file)->toMediaCollection($collection);
        if($EStandardization->save()) {
            return response()->json(['success' => 'File Updated']);
        }
        return response()->json(['error' => 'Error Uploading File']);
    }
}
