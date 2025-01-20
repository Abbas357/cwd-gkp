<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Standardization;

use Yajra\DataTables\DataTables;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\Encoding\Encoding;
use App\Mail\Standardization\RenewedMail;
use App\Mail\Standardization\ApprovedMail;
use App\Mail\Standardization\RejectedMail;

class StandardizationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $standardizations = Standardization::query();

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

    public function show(Standardization $standardization)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $standardization,
            ],
        ]);
    }

    public function showDetail($id)
    {
        $Standardization = Standardization::find($id);
        if (!$Standardization) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Product detail',
                ],
            ]);
        }
        $html = view('admin.standardizations.partials.detail', compact('Standardization'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function showCard($id)
    {
        $Standardization = Standardization::find($id);
        if ($Standardization->status !== 'approved') {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'The Product is not standardized',
                ],
            ]);
        }
        $data = route('standardizations.approved', ['uuid' => $Standardization->uuid]);
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(1)
            ->build();

        $qrCodeUri = $qrCode->getDataUri();

        $html = view('admin.standardizations.partials.card', compact('Standardization', 'qrCodeUri'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function approve(Request $request, Standardization $standardization)
    {
        if ($standardization->status !== 'approved') {
            $standardization->status = 'approved';
            $standardization->card_issue_date = Carbon::now();
            $standardization->card_expiry_date = Carbon::now()->addYears(3);
            if($standardization->save()) {
                Mail::to($standardization->email)->queue(new ApprovedMail($standardization));
                return response()->json(['success' => 'Product has been approved successfully.']);
            }
        }
        return response()->json(['error' => 'Product can\'t be approved.']);
    }

    public function renew(Request $request, Standardization $standardization)
    {
        $currentDate = Carbon::now();

        if ($standardization->status === 'approved') {
            if ($currentDate->greaterThanOrEqualTo($standardization->card_expiry_date)) {
                $standardization->card_issue_date = $request->issue_date ?? $currentDate;
                $standardization->card_expiry_date = Carbon::parse($standardization->card_issue_date)->addYears(3);

                if ($standardization->save()) {
                    Mail::to($standardization->email)->queue(new RenewedMail($standardization));
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

    public function reject(Request $request, Standardization $standardization)
    {
        if (!in_array($standardization->status, ['approved', 'rejected'])) {
            $standardization->status = 'rejected';
            $standardization->remarks = $request->remarks;

            if($standardization->save()) {
                Mail::to($standardization->email)->queue(new RejectedMail($standardization, $request->reason));
                return response()->json(['success' => 'Product has been rejected.']);
            }
        }
        return response()->json(['error' => 'Product can\'t be rejected.']);
    }

    public function updateField(Request $request, Standardization $standardization)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        if(($request->has('expiry_date') || $request->has('issue_date')) && $standardization->status !== 'new') {
            return response()->json(['error' => 'Approved or Rejected Products cannot be updated']);
        }
        $standardization->{$request->field} = $request->value;
        $standardization->save();

        return response()->json(['success' => 'Field saved']);
    }

    public function uploadFile(Request $request, Standardization $standardization)
    {
        if($request->hasFile('firm_pictures') && $standardization->status !== 'new') {
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
