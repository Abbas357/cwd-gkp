<?php

namespace App\Http\Controllers;

use App\Models\ContractorRegistration;
use App\Http\Requests\StoreContractorRegistrationRequest;
use App\Models\District;
use Illuminate\Http\Request;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;

use App\Models\Category;

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
                    return view('admin.cont_registrations.partials.buttons', compact('row'))->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->diffForHumans();
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->editColumn('status', function ($row) {
                    return $row->status === 1 ? 'Deferred 1 time' :
                            ($row->status === 2 ? 'Deferred 2 time' :
                            ($row->status === 3 ? 'Deferred 3 time' :
                            ($row->status === 4 ? 'Approved' : 'Nil')));
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

        return view('admin.cont_registrations.index');
    }

    public function defer(Request $request, ContractorRegistration $ContractorRegistration)
    {
        if (!in_array($ContractorRegistration->status, [3, 4])) {
            $ContractorRegistration->status += 1;
            $ContractorRegistration->save();
            return response()->json(['success' => 'Registration has been deferred successfully.']);
        }

        return response()->json(['error' => 'Registration can\'t be deferred further or has already been approved.']);
    }


    public function approve(Request $request, ContractorRegistration $ContractorRegistration)
    {
        if (!in_array($ContractorRegistration->status, [3, 4])) {
            $ContractorRegistration->status = 4;
            $ContractorRegistration->save();
            return response()->json(['success' => 'Registration has been approved successfully.']);
        }
        return response()->json(['error' => 'Registration can\'t be approved.']);
    }


    public function create()
    {
        $cat = [
            'districts' => District::all(),
            'contractor_category' => Category::where('type', 'contractor_category')->get(),
            'provincial_entities' => Category::where('type', 'provincial_entity')->get(),
        ];
        return view('admin.cont_registrations.create', compact('cat'));
    }

    public function store(StoreContractorRegistrationRequest $request)
    {
        $registration = new ContractorRegistration();
        if ($registration->where('pec_number', $request->input('pec_number'))->where('defer_status', '!=', 3)->exists()) {
            return redirect()->route('admin.registrations.create')->with('danger', 'User with this PEC Number already exists');
        }
        $registration->owner_name = $request->input('owner_name');
        $registration->district = $request->input('district');
        $registration->pec_number = $request->input('pec_number');
        $registration->category_applied = $request->input('category_applied');
        $registration->contractor_name = $request->input('contractor_name');
        $registration->address = $request->input('address');
        $registration->pec_category = $request->input('pec_category');
        $registration->cnic = $request->input('cnic');
        $registration->fbr_ntn = $request->input('fbr_ntn');
        $registration->kpra_reg_no = $request->input('kpra_reg_no');
        $registration->email = $request->input('email');
        $registration->mobile_number = $request->input('mobile_number');
        $registration->is_limited = $request->input('is_limited');
        $registration->is_agreed = $request->input('is_agreed');

        if ($request->has('pre_enlistment')) {
            $registration->pre_enlistment = json_encode($request->input('pre_enlistment'));
        }

        if ($request->hasFile('cnic_front_attachment')) {
            $registration->addMedia($request->file('cnic_front_attachment'))
                ->toMediaCollection('cnic_front_attachments');
        }

        if ($request->hasFile('cnic_back_attachment')) {
            $registration->addMedia($request->file('cnic_back_attachment'))
                ->toMediaCollection('cnic_back_attachments');
        }

        if ($request->hasFile('fbr_attachment')) {
            $registration->addMedia($request->file('fbr_attachment'))
                ->toMediaCollection('fbr_attachments');
        }

        if ($request->hasFile('kpra_attachment')) {
            $registration->addMedia($request->file('kpra_attachment'))
                ->toMediaCollection('kpra_attachments');
        }

        if ($request->hasFile('pec_attachment')) {
            $registration->addMedia($request->file('pec_attachment'))
                ->toMediaCollection('pec_attachments');
        }

        if ($request->hasFile('form_h_attachment')) {
            $registration->addMedia($request->file('form_h_attachment'))
                ->toMediaCollection('form_h_attachments');
        }

        if ($request->hasFile('pre_enlistment_attachment')) {
            $registration->addMedia($request->file('pre_enlistment_attachment'))
                ->toMediaCollection('pre_enlistment_attachments');
        }

        if ($registration->save()) {
            return redirect()->route('admin.registrations.create')->with('success', 'Your form has been submitted successfully');
        }
        return redirect()->route('admin.registrations.create')->with('danger', 'There is an error submitting your data');
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

    public function approvedContractors(Request $request, $id)
    {
        $registration = ContractorRegistration::find($id);
        return view('admin.cont_registrations.approved', compact('registration'));
    }

    public function showCard(ContractorRegistration $ContractorRegistration)
    {
        if ($ContractorRegistration->status !== 4) {
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

    public function checkPEC(Request $request)
    {
        $pecNumber = $request->input('pec_number');
        $exists = ContractorRegistration::where('pec_number', $pecNumber)->where('status', '!=', 3)->exists();
        return response()->json(['unique' => !$exists]);
    }

    public function updateField(Request $request)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required',
        ]);

        $ContractorRegistration = ContractorRegistration::find($request->id);
        if (in_array($ContractorRegistration->status, [3, 4])) {
            return response()->json(['error' => 'Approved or Rejected Registrations cannot be updated']);
        }
        if ($request->field === 'pec_number') {
            if (ContractorRegistration::where('pec_number', $request->value)->where('status', '!=', 3)->exists()) {
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
        if ($ContractorRegistration->status === 1 && $ContractorRegistration->defer_status === 3) {
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
