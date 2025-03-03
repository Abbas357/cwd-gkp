<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Endroid\QrCode\Builder\Builder;
use App\Mail\Contractor\RenewedMail;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\Encoding\Encoding;
use App\Models\ContractorRegistration;

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
                    return view('modules.contractors.registration.partials.buttons', compact('row'))->render();
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

        return view('modules.contractors.registration.index');
    }

    public function defer(Request $request, ContractorRegistration $ContractorRegistration)
    {
        $ContractorRegistration->remarks = $request->remarks;
        if ($ContractorRegistration->status == "new") {
            $ContractorRegistration->status = "deffered_once";
        } elseif ($ContractorRegistration->status == "deffered_once") {
            $ContractorRegistration->status = "deffered_twice";
        } elseif ($ContractorRegistration->status == "deffered_twice") {
            $ContractorRegistration->status = "deffered_thrice";
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
            $ContractorRegistration->save();
            return response()->json(['success' => 'Contractor has been approved successfully.']);
        }
        return response()->json(['error' => 'Contractor can\'t be approved.']);
    }

    public function renew(ContractorRegistration $ContractorRegistration)
    {
        $currentDate = Carbon::now();
        $latestCard = $ContractorRegistration->getLatestCard();

        if (!$latestCard) {
            return response()->json(['error' => 'No active card found for renewal.']);
        }
        
        $ContractorRegistration->cards()->where('status', 'active')->update(['status' => 'expired']);

        if ($currentDate->greaterThanOrEqualTo($latestCard->expiry_date)) {
            $ContractorRegistration->cards()->create([
                'uuid' => \Illuminate\Support\Str::uuid(),
                'issue_date' => $currentDate,
                'expiry_date' => $currentDate->addYear(),
                'status' => 'active',
            ]);
            
            Mail::to($ContractorRegistration->contractor->email)->queue(new RenewedMail($ContractorRegistration));

            return response()->json(['success' => 'Contractor card has been renewed successfully.']);
        } else {
            return response()->json(['error' => 'Contractor card cannot be renewed because it has not yet expired.']);
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
        $html = view('modules.contractors.registration.partials.detail', compact('ContractorRegistration', 'cat'))->render();
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
        $data = route('contractors.approved', ['uuid' => $ContractorRegistration->uuid]);
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(1)
            ->build();

        $qrCodeUri = $qrCode->getDataUri();

        $html = view('modules.contractors.registration.partials.card', compact('ContractorRegistration', 'qrCodeUri'))->render();
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
