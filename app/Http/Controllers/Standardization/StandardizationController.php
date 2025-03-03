<?php

namespace App\Http\Controllers\Standardization;

use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Standardization;

use Yajra\DataTables\DataTables;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\Encoding\Encoding;
use App\Mail\Standardization\RenewedMail;

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
                    return view('modules.standardizations.partials.buttons', compact('row'))->render();
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

        return view('modules.standardizations.index');
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
                    'result' => 'Unable to load Standardization detail',
                ],
            ]);
        }
        $html = view('modules.standardizations.partials.detail', compact('Standardization'))->render();
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
                    'result' => 'The Standardization is not standardized',
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

        $html = view('modules.standardizations.partials.card', compact('Standardization', 'qrCodeUri'))->render();
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
            if($standardization->save()) {
                return response()->json(['success' => 'Standardization has been approved successfully.']);
            }
        }
        return response()->json(['error' => 'Standardization can\'t be approved.']);
    }

    public function renew(Request $request, Standardization $Standardization)
    {
        $currentDate = Carbon::now();
        $latestCard = $Standardization->getLatestCard();

        if (!$latestCard) {
            return response()->json(['error' => 'No active card found for renewal.']);
        }
        
        $Standardization->cards()->where('status', 'active')->update(['status' => 'expired']);

        if ($currentDate->greaterThanOrEqualTo($latestCard->expiry_date)) {
            $Standardization->cards()->create([
                'uuid' => \Illuminate\Support\Str::uuid(),
                'issue_date' => $currentDate,
                'expiry_date' => $currentDate->addYear(),
                'status' => 'active',
            ]);
            
            Mail::to($Standardization->email)->queue(new RenewedMail($Standardization));

            return response()->json(['success' => 'Standardization Card has been renewed successfully.']);
        } else {
            return response()->json(['error' => 'Standardization Card cannot be renewed because it has not yet expired.']);
        }
    }

    public function reject(Request $request, Standardization $standardization)
    {
        if (!in_array($standardization->status, ['approved', 'rejected'])) {
            $standardization->status = 'rejected';

            if($standardization->save()) {
                return response()->json(['success' => 'Application has been rejected.']);
            }
        }
        return response()->json(['error' => 'Standardization application can\'t be rejected.']);
    }

    public function updateField(Request $request, Standardization $standardization)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        if(($request->has('expiry_date') || $request->has('issue_date')) && $standardization->status !== 'new') {
            return response()->json(['error' => 'Approved or Rejected Standardization cannot be updated']);
        }
        $standardization->{$request->field} = $request->value;
        $standardization->save();

        return response()->json(['success' => 'Field saved']);
    }

    public function uploadFile(Request $request, Standardization $standardization)
    {
        if($request->hasFile('firm_pictures') && $standardization->status !== 'new') {
            return response()->json(['error' => 'Approved or Rejected Standardization cannot be updated']);
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
