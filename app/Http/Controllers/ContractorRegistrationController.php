<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\District;
use App\Models\ContractorRegistration;

use Yajra\DataTables\DataTables;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContractorRegistrationApprovedMail;
use App\Mail\ContractorRegistrationDeferredFirstMail;
use App\Mail\ContractorRegistrationDeferredThirdMail;
use App\Mail\ContractorRegistrationDeferredSecondMail;

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
                    return view('admin.cont_registrations.partials.buttons', compact('row'))->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at?->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action']);

            // if (!$request->input('search.value') && $request->has('searchBuilder')) {
            //     $dataTable->filter(function ($query) use ($request) {
            //         $sb = new \App\SearchBuilder($request, $query);
            //         $sb->build();
            //     });
            // }

            return $dataTable->toJson();
        }

        return view('admin.cont_registrations.index');
    }

    public function defer(Request $request, ContractorRegistration $ContractorRegistration)
    {
        $ContractorRegistration->deffered_reason = $request->reason;
        if ($ContractorRegistration->status == "fresh") {
            $ContractorRegistration->status = "deffered_one";
            Mail::to($ContractorRegistration->email)->queue(new ContractorRegistrationDeferredFirstMail($ContractorRegistration, $request->reason));
        } elseif ($ContractorRegistration->status == "deffered_one") {
            $ContractorRegistration->status = "deffered_two";
            Mail::to($ContractorRegistration->email)->queue(new ContractorRegistrationDeferredSecondMail($ContractorRegistration, $request->reason));
        } elseif ($ContractorRegistration->status == "deffered_two") {
            $ContractorRegistration->status = "deffered_three";;
            Mail::to($ContractorRegistration->email)->queue(new ContractorRegistrationDeferredThirdMail($ContractorRegistration, $request->reason));
        }
        if($ContractorRegistration->save()) {
            return response()->json(['success' => 'Registration has been deferred successfully.']);
        }
        return response()->json(['error' => 'Registration can\'t be deferred further or has already been approved.']);
    }


    public function approve(Request $request, ContractorRegistration $ContractorRegistration)
    {
        if (!in_array($ContractorRegistration->status, ["deffered_three", 'approved'])) {
            $ContractorRegistration->status = 'approved';
            $ContractorRegistration->save();
            Mail::to($ContractorRegistration->email)->queue(new ContractorRegistrationApprovedMail($ContractorRegistration));
            return response()->json(['success' => 'Registration has been approved successfully.']);
        }
        return response()->json(['error' => 'Registration can\'t be approved.']);
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
            'districts' => District::all(),
            'contractor_category' => Category::where('type', 'contractor_category')->get(),
            'provincial_entities' => Category::where('type', 'provincial_entity')->get(),
        ];

        if (!$ContractorRegistration) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Registration detail',
                ],
            ]);
        }
        $html = view('admin.cont_registrations.partials.detail', compact('ContractorRegistration', 'cat'))->render();
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
                    'result' => 'The Product is not standardized',
                ],
            ]);
        }
        $data = route('registrations.approved', ['id' => $ContractorRegistration->id]);
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(1)
            ->build();

        $qrCodeUri = $qrCode->getDataUri();

        $html = view('admin.cont_registrations.partials.card', compact('ContractorRegistration', 'qrCodeUri'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required',
        ]);

        $ContractorRegistration = ContractorRegistration::find($request->id);
        if (($request->has('reg_no') || $request->has('expiry_date') || $request->has('issue_date')) && in_array($ContractorRegistration->status, ['approved_three', 'approved'])) {
            return response()->json(['error' => 'Approved or Rejected Registrations cannot be updated']);
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

    public function uploadFile(Request $request)
    {
        $ContractorRegistration = ContractorRegistration::find($request->id);
        if ($request->hasFile('contractor_pictures') && in_array($ContractorRegistration->status, ['approved_three', 'approved'])) {
            return response()->json(['error' => 'Approved or Rejected Registrations cannot be updated']);
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
