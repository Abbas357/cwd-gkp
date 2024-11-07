<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\District;
use App\Models\ContractorRegistration;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContractorRegistrationAppliedMail;
use App\Http\Requests\StoreContractorRegistrationRequest;

class ContractorRegistrationController extends Controller
{
    public function create()
    {
        $cat = [
            'districts' => District::all(),
            'contractor_category' => Category::where('type', 'contractor_category')->get(),
            'provincial_entities' => Category::where('type', 'provincial_entity')->get(),
        ];
        return view('site.cont_registrations.create', compact('cat'));
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

        if ($request->has('pre_enlistment')) {
            $registration->pre_enlistment = json_encode($request->input('pre_enlistment'));
        }

        if ($request->hasFile('contractor_picture')) {
            $registration->addMedia($request->file('contractor_picture'))
                ->toMediaCollection('contractor_pictures');
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
            Mail::to($registration->email)->queue(new ContractorRegistrationAppliedMail($registration));
            return redirect()->route('registrations.create')->with('success', 'Your form has been submitted successfully');
        }
        return redirect()->route('registrations.create')->with('danger', 'There is an error submitting your data');
    }

    public function checkPEC(Request $request)
    {
        $pecNumber = $request->input('pec_number');
        $exists = ContractorRegistration::where('pec_number', $pecNumber)->where('status', '!=', 3)->exists();
        return response()->json(['unique' => !$exists]);
    }

    public function approvedContractors(Request $request, $id)
    {
        $registration = ContractorRegistration::find($id);
        return view('admin.cont_registrations.approved', compact('registration'));
    }
}
