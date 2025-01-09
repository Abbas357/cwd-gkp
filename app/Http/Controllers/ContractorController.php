<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\Category;
use App\Models\District;
use Illuminate\Http\Request;

use Yajra\DataTables\DataTables;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;

use Endroid\QrCode\Encoding\Encoding;
use App\Models\Contractor;
use App\Mail\Contractor\RenewedMail;
use App\Mail\Contractor\ApprovedMail;
use App\Mail\Contractor\DeferredFirstMail;
use App\Mail\Contractor\DeferredThirdMail;
use App\Mail\Contractor\DeferredSecondMail;

class ContractorController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $contractors = Contractor::query();

        $contractors->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($contractors)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.contractors.partials.buttons', compact('row'))->render();
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

        return view('admin.contractors.index');
    }

    public function defer(Request $request, Contractor $Contractor)
    {
        $Contractor->deffered_reason = $request->reason;
        if ($Contractor->status == "fresh") {
            $Contractor->status = "deffered_one";
            Mail::to($Contractor->email)->queue(new DeferredFirstMail($Contractor, $request->reason));
        } elseif ($Contractor->status == "deffered_one") {
            $Contractor->status = "deffered_two";
            Mail::to($Contractor->email)->queue(new DeferredSecondMail($Contractor, $request->reason));
        } elseif ($Contractor->status == "deffered_two") {
            $Contractor->status = "deffered_three";;
            Mail::to($Contractor->email)->queue(new DeferredThirdMail($Contractor, $request->reason));
        }
        if($Contractor->save()) {
            return response()->json(['success' => 'Contractor has been deferred successfully.']);
        }
        return response()->json(['error' => 'Contractor can\'t be deferred further or has already been approved.']);
    }


    public function approve(Request $request, Contractor $Contractor)
    {
        if (!in_array($Contractor->status, ["deffered_three", 'approved'])) {
            $Contractor->status = 'approved';
            $Contractor->card_issue_date = Carbon::now();
            $Contractor->card_expiry_date = Carbon::now()->addYears(1);
            $Contractor->save();
            Mail::to($Contractor->email)->queue(new ApprovedMail($Contractor));
            return response()->json(['success' => 'Contractor has been approved successfully.']);
        }
        return response()->json(['error' => 'Contractor can\'t be approved.']);
    }

    public function renew(Request $request, Contractor $Contractor)
    {
        $currentDate = Carbon::now();

        if ($Contractor->status === 'approved') {
            if ($currentDate->greaterThanOrEqualTo($Contractor->card_expiry_date)) {
                $Contractor->card_issue_date = $request->issue_date ?? $currentDate;
                $Contractor->card_expiry_date = Carbon::parse($Contractor->card_issue_date)->addYears(1);

                if ($Contractor->save()) {
                    Mail::to($Contractor->email)->queue(new RenewedMail($Contractor));
                    return response()->json(['success' => 'Contractor card has been renewed successfully.']);
                } else {
                    return response()->json(['error' => 'An error occurred while saving the card data. Please try again.']);
                }
            } else {
                return response()->json(['error' => 'Contractor card cannot be renewed because it has not yet expired.']);
            }
        } else {
            return response()->json(['error' => 'Contractor card status does not allow renewal.']);
        }
    }

    public function show(Contractor $Contractor)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $Contractor,
            ],
        ]);
    }

    public function showDetail(Contractor $Contractor)
    {
        $cat = [
            'districts' => District::all(),
            'contractor_category' => Category::where('type', 'contractor_category')->get(),
            'provincial_entities' => Category::where('type', 'provincial_entity')->get(),
        ];

        if (!$Contractor) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Contractor detail',
                ],
            ]);
        }
        $html = view('admin.contractors.partials.detail', compact('Contractor', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function showCard(Contractor $Contractor)
    {
        if ($Contractor->status !== 'approved') {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Contractor is not verified',
                ],
            ]);
        }
        $data = route('contractors.approved', ['id' => $Contractor->id]);
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(1)
            ->build();

        $qrCodeUri = $qrCode->getDataUri();

        $html = view('admin.contractors.partials.card', compact('Contractor', 'qrCodeUri'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Contractor $Contractor)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required',
        ]);

        if (($request->has('reg_no') || $request->has('expiry_date') || $request->has('issue_date')) && in_array($Contractor->status, ['approved_three', 'approved'])) {
            return response()->json(['error' => 'Approved or Rejected Contractors cannot be updated']);
        }
        if ($request->field === 'pec_number') {
            if (Contractor::where('pec_number', $request->value)->where('status', '!=', 'approved')->exists()) {
                return response()->json(['error' => 'PEC number already exists']);
            }
        }

        $Contractor->{$request->field} = $request->field === 'pre_enlistment'
            ? json_encode($request->value)
            : $request->value;
        $Contractor->save();

        return response()->json(['success' => 'Field saved']);
    }

    public function uploadFile(Request $request, Contractor $Contractor)
    {
        if ($request->hasFile('contractor_pictures') && in_array($Contractor->status, ['approved_three', 'approved'])) {
            return response()->json(['error' => 'Approved or Rejected Contractors cannot be updated']);
        }
        $file = $request->file;
        $collection = $request->collection;
        $Contractor->addMedia($file)->toMediaCollection($collection);
        if ($Contractor->save()) {
            return response()->json(['success' => 'File Updated']);
        }
        return response()->json(['error' => 'Error Uploading File']);
    }
}
