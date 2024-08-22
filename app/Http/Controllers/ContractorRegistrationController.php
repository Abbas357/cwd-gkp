<?php

namespace App\Http\Controllers;

use App\Models\ContractorRegistration;
use App\Http\Requests\StoreContractorRegistrationRequest;
use App\Http\Requests\UpdateContractorRegistrationRequest;

use App\Models\District;
use App\Models\Collection;
use DataTables;
use App\SearchBuilder;
use Illuminate\Http\Request;

class ContractorRegistrationController extends Controller
{

    public function index(Request $request)
    {
        $defer = ($defer = $request->query('defer') ?? 0) >= 0 && $defer <= 3 ? $defer : 0;
        $approved = $request->query('approved', null);

        $registrations = ContractorRegistration::query();

        if ($approved !== null) {
            $defer = null;
        } elseif ($defer !== null) {
            $approved = null;
        }

        if ($defer !== null) {
            $registrations->where('defer_status', $defer)->where('approval_status', 0);
        }

        if ($approved !== null) {
            $registrations->where('approval_status', $approved);
        }

        $mapColumns = [];

        if ($request->ajax()) {

            return Datatables::of($registrations)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return view('cont_registrations.partials.buttons', compact('row'))->render();
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->diffForHumans();
                })
                ->editColumn('updated_at', function($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->filter(function ($query) use ($request) {
                    $sb = new SearchBuilder($request, $query);
                    $query = $sb->build();
                })
                ->rawColumns(['action'])
                ->toJson();
        }
          
        return view('cont_registrations.index');
    }

    public function data(Request $request)
    {
        $defer = ($defer = $request->query('defer') ?? 0) >= 0 && $defer <= 3 ? $defer : 0;
        $approved = $request->query('approved', null);

        $registrations = ContractorRegistration::query()->orderByDesc('created_at');

        if ($approved !== null) {
            $defer = null;
        } elseif ($defer !== null) {
            $approved = null;
        }

        if ($defer !== null) {
            $registrations->where('defer_status', $defer)->where('approval_status', 0);
        }

        if ($approved !== null) {
            $registrations->where('approval_status', $approved);
        }

        $searchable = [
            'category_applied',
            'contractor_name',
            'address',
            'pec_category',
            'cnic',
            'district',
            'pec_number',
            'owner_name',
            'fbr_ntn',
            'kpra_reg_no',
            'email',
            'mobile_number',
            'is_limited',
        ];

        $records = function ($record) {
            return [
                'id' => $record->id,
                'mobile_number' => $record->mobile_number,
                'email' => $record->email,
                'cnic' => $record->cnic,
                'owner_name' => $record->owner_name,
                'district' => $record->district,
                'address' => $record->address,
                'pec_number' => $record->pec_number,
                'category_applied' => $record->category_applied,
                'contractor_name' => $record->contractor_name,
                'pec_category' => $record->pec_category,
                'fbr_ntn' => $record->fbr_ntn,
                'kpra_reg_no' => $record->kpra_reg_no,
                'is_limited' => $record->is_limited,
                'is_agreed' => $record->is_agreed,
                'defer_status' => $record->defer_status,
                'approval_status' => $record->approval_status,
                'created_at' => $record->created_at->diffForHumans(),
                'updated_at' => $record->updated_at->diffForHumans(),
            ];
        };

        return $this->DataTable($registrations, $searchable, $records);
    }

    public function defer(Request $request, ContractorRegistration $ContractorRegistration)
    {
        if ($ContractorRegistration->approval_status == 0 && $ContractorRegistration->defer_status < 3) {
            $ContractorRegistration->defer_status += 1;
            $ContractorRegistration->save();
            return response()->json(['success' => 'Registration has been deferred successfully.']);
        }

        return response()->json(['error' => 'Registration can\'t be deferred further or has already been approved.']);
    }


    public function approve(Request $request, ContractorRegistration $ContractorRegistration)
    {
        if ($ContractorRegistration->approval_status !== 1 && $ContractorRegistration->defer_status !== 3) {
            $ContractorRegistration->approval_status = 1;
            $ContractorRegistration->save();
            return response()->json(['success' => 'Registration has been approved successfully.']);
        }
        return response()->json(['error' => 'Registration can\'t be approved.']);
    }


    public function create()
    {
        $cat = [
            'districts' => District::all(),
            'contractor_category' => Collection::where('type', 'contractor_category')->get(),
            'provincial_entities' => Collection::where('type', 'provincial_entities')->get(),
        ];
        return view('cont_registrations.create', compact('cat'));
    }

    public function store(StoreContractorRegistrationRequest $request)
    {
        $registration = new ContractorRegistration();

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
            $registration->cnic_front_attachment = $request->file('cnic_front_attachment')->store('registrations/cnic', 'public');
        }

        if ($request->hasFile('cnic_back_attachment')) {
            $registration->cnic_back_attachment = $request->file('cnic_back_attachment')->store('registrations/cnic', 'public');
        }

        if ($request->hasFile('fbr_attachment')) {
            $registration->fbr_attachment = $request->file('fbr_attachment')->store('registrations/fbr', 'public');
        }

        if ($request->hasFile('kpra_attachment')) {
            $registration->kpra_attachment = $request->file('kpra_attachment')->store('registrations/kpra', 'public');
        }

        if ($request->hasFile('pec_attachment')) {
            $registration->pec_attachment = $request->file('pec_attachment')->store('registrations/pec', 'public');
        }

        if ($request->hasFile('form_h_attachment')) {
            $registration->form_h_attachment = $request->file('form_h_attachment')->store('registrations/form_h', 'public');
        }

        if ($request->hasFile('pre_enlistment_attachment')) {
            $registration->pre_enlistment_attachment = $request->file('pre_enlistment_attachment')->store('registrations/pre_enlistment', 'public');
        }

        if ($registration->save()) {
            return redirect()->route('registrations.create')->with('success', 'Your form has been submitted successfully');
        }
        return redirect()->route('registrations.create')->with('danger', 'There is an error submitting your data');
    }

    public function show(ContractorRegistration $ContractorRegistration)
    {
        return view('cont_registrations.show', compact('ContractorRegistration'));
    }

    public function checkPecNumber(Request $request)
    {
        $pecNumber = $request->input('pec_number');
        $exists = ContractorRegistration::where('pec_number', $pecNumber)->where('defer_status', '!=', 3)->exists();
        return response()->json(['unique' => !$exists]);
    }

    public function edit(ContractorRegistration $ContractorRegistration)
    {
        //
    }

    public function update(UpdateContractorRegistrationRequest $request, ContractorRegistration $ContractorRegistration)
    {
        //
    }

    public function destroy(ContractorRegistration $ContractorRegistration)
    {
        //
    }
}
