<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Category;
use App\Models\District;
use App\Models\Contractor;
use Illuminate\Http\Request;
use Endroid\QrCode\Builder\Builder;
use App\Http\Controllers\Controller;
use App\Mail\Contractor\RenewedMail;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contractor\ApprovedMail;
use Endroid\QrCode\Encoding\Encoding;
use App\Models\ContractorRegistration;
use App\Mail\Contractor\DeferredFirstMail;
use App\Mail\Contractor\DeferredThirdMail;
use App\Mail\Contractor\DeferredSecondMail;
use App\Http\Requests\StoreContractorRegistrationRequest;
use Yajra\DataTables\DataTables;

class ContractorRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $registrations = ContractorRegistration::query();

        $registrations->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($registrations)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.contractors.registration.partials.buttons', compact('row'))->render();
                })
                ->addColumn('name', function ($row) {
                    return $row->contractor->name;
                })
                ->addColumn('firm_name', function ($row) {
                    return $row->contractor->firm_name;
                })
                ->addColumn('email', function ($row) {
                    return $row->contractor->email;
                })
                ->addColumn('mobile_number', function ($row) {
                    return $row->contractor->mobile_number;
                })
                ->addColumn('cnic', function ($row) {
                    return $row->contractor->cnic;
                })
                ->addColumn('district', function ($row) {
                    return $row->contractor->district;
                })
                ->addColumn('address', function ($row) {
                    return $row->contractor->address;
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

        return view('admin.contractors.registration.index');
    }

    public function defer(Request $request, ContractorRegistration $ContractorRegistration)
    {
        $ContractorRegistration->deffered_reason = $request->reason;
        if ($ContractorRegistration->status == "new") {
            $ContractorRegistration->status = "deffered_once";
            // Mail::to($ContractorRegistration->email)->queue(new DeferredFirstMail($ContractorRegistration, $request->reason));
        } elseif ($ContractorRegistration->status == "deffered_once") {
            $ContractorRegistration->status = "deffered_twice";
            // Mail::to($ContractorRegistration->email)->queue(new DeferredSecondMail($ContractorRegistration, $request->reason));
        } elseif ($ContractorRegistration->status == "deffered_twice") {
            $ContractorRegistration->status = "deffered_thrice";;
            // Mail::to($ContractorRegistration->email)->queue(new DeferredThirdMail($ContractorRegistration, $request->reason));
        }
        if($ContractorRegistration->save()) {
            return response()->json(['success' => 'Contractor has been deferred successfully.']);
        }
        return response()->json(['error' => 'Contractor can\'t be deferred further or has already been approved.']);
    }


    public function approve(Request $request, ContractorRegistration $ContractorRegistration)
    {
        if (!in_array($ContractorRegistration->status, ["deffered_thrice", 'approved'])) {
            $ContractorRegistration->status = 'approved';
            $ContractorRegistration->card_issue_date = Carbon::now();
            $ContractorRegistration->card_expiry_date = Carbon::now()->addYears(1);
            $ContractorRegistration->save();
            // Mail::to($ContractorRegistration->email)->queue(new ApprovedMail($ContractorRegistration));
            return response()->json(['success' => 'Contractor has been approved successfully.']);
        }
        return response()->json(['error' => 'Contractor can\'t be approved.']);
    }

    public function renew(Request $request, ContractorRegistration $ContractorRegistration)
    {
        $currentDate = Carbon::now();

        if ($ContractorRegistration->status === 'approved') {
            if ($currentDate->greaterThanOrEqualTo($ContractorRegistration->card_expiry_date)) {
                $ContractorRegistration->card_issue_date = $request->issue_date ?? $currentDate;
                $ContractorRegistration->card_expiry_date = Carbon::parse($ContractorRegistration->card_issue_date)->addYears(1);

                if ($ContractorRegistration->save()) {
                    // Mail::to($ContractorRegistration->email)->queue(new RenewedMail($ContractorRegistration));
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

    public function show(ContractorRegistration $ContractorRegistration)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $ContractorRegistration,
            ],
        ]);
    }

    public function showDetail(ContractorRegistration $ContractorRegistration)
    {
        $cat = [
            'contractor_category' => Category::where('type', 'contractor_category')->get(),
            'provincial_entities' => Category::where('type', 'provincial_entity')->get(),
        ];

        if (!$ContractorRegistration) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Contractor detail',
                ],
            ]);
        }
        $html = view('admin.contractors.registration.partials.detail', compact('ContractorRegistration', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function showCard(ContractorRegistration $ContractorRegistration)
    {
        if ($ContractorRegistration->status !== 'approved') {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Contractor is not approved',
                ],
            ]);
        }
        $data = route('contractors.approved', ['id' => $ContractorRegistration->id]);
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(1)
            ->build();

        $qrCodeUri = $qrCode->getDataUri();

        $html = view('admin.contractors.registration.partials.card', compact('ContractorRegistration', 'qrCodeUri'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, ContractorRegistration $ContractorRegistration)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required',
        ]);

        if (($request->has('reg_no') || $request->has('expiry_date') || $request->has('issue_date')) && in_array($ContractorRegistration->status, ['deffered_thrice', 'approved'])) {
            return response()->json(['error' => 'Approved or Rejected Contractors cannot be updated']);
        }
        if ($request->field === 'pec_number') {
            if (ContractorRegistration::where('pec_number', $request->value)->where('status', '!=', 'approved')->exists()) {
                return response()->json(['error' => 'PEC number already exists']);
            }
        }

        $ContractorRegistration->{$request->field} = $request->field === 'pre_enlistment'
            ? json_encode($request->value)
            : $request->value;
        $ContractorRegistration->save();

        return response()->json(['success' => 'Field saved']);
    }

    public function uploadFile(Request $request, ContractorRegistration $ContractorRegistration)
    {
        if ($request->hasFile('contractor_pictures') && in_array($ContractorRegistration->status, ['deffered_thrice', 'approved'])) {
            return response()->json(['error' => 'Approved or Rejected Contractors cannot be updated']);
        }
        $file = $request->file;
        $collection = $request->collection;
        $ContractorRegistration->addMedia($file)->toMediaCollection($collection);
        if ($ContractorRegistration->save()) {
            return response()->json(['success' => 'File Updated']);
        }
        return response()->json(['error' => 'Error Uploading File']);
    }
}
