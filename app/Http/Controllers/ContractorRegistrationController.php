<?php

namespace App\Http\Controllers;

use App\Models\ContractorRegistration;
use App\Http\Requests\StoreContractorRegistrationRequest;
use App\Http\Requests\UpdateContractorRegistrationRequest;

use App\Models\District;
use App\Models\Collection;
use DataTables;
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

        if ($request->ajax()) {
            $dataTable = Datatables::of($registrations)
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
                ->editColumn('approval_status', function($row) {
                    return $row->approval_status === 1 ? 'Approved' : 'Not Approved';
                })
                ->editColumn('defer_status', function($row) {
                    return $row->defer_status === 0 ? 'Not Deffered' : ($row->defer_status === 1 ? 'First time deffered' : ($row->defer_status === 2 ? '2nd time deffered' : '3rd time deffered') );
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
          
        return view('cont_registrations.index');
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
        if($registration->where('pec_number', $request->input('pec_number'))->where('defer_status', '!=', 3)->exists()) {
            return redirect()->route('registrations.create')->with('danger', 'User with this PEC Number already exists');
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
