<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\StoreEStandardizationRequest;

use App\Models\EStandardization;

use Illuminate\Support\Facades\Mail;
use App\Mail\StandardizationAppliedMail;

class EStandardizationController extends Controller
{
    public function create()
    {
        return view('site.standardizations.create');
    }

    public function store(StoreEStandardizationRequest $request)
    {
        $standardization = new EStandardization();
        $standardization->product_name = $request->input('product_name');
        $standardization->specification_details = $request->input('specification_details');
        $standardization->firm_name = $request->input('firm_name');
        $standardization->address = $request->input('address');
        $standardization->mobile_number = $request->input('mobile_number');
        $standardization->phone_number = $request->input('phone_number');
        $standardization->email = $request->input('email');
        $standardization->locality = $request->input('locality');
        $standardization->ntn_number = $request->input('ntn_number');
        $standardization->location_type = $request->input('location_type');

        if ($request->hasFile('secp_certificate')) {
            $standardization->addMedia($request->file('secp_certificate'))
                ->toMediaCollection('secp_certificates');
        }

        if ($request->hasFile('iso_certificate')) {
            $standardization->addMedia($request->file('iso_certificate'))
                ->toMediaCollection('iso_certificates');
        }

        if ($request->hasFile('commerce_membership')) {
            $standardization->addMedia($request->file('commerce_membership'))
                ->toMediaCollection('commerse_memberships');
        }

        if ($request->hasFile('pec_certificate')) {
            $standardization->addMedia($request->file('pec_certificate'))
                ->toMediaCollection('pec_certificates');
        }

        if ($request->hasFile('annual_tax_returns')) {
            $standardization->addMedia($request->file('annual_tax_returns'))
                ->toMediaCollection('annual_tax_returns');
        }

        if ($request->hasFile('audited_financial')) {
            $standardization->addMedia($request->file('audited_financial'))
                ->toMediaCollection('audited_financials');
        }

        if ($request->hasFile('dept_org_cert')) {
            $standardization->addMedia($request->file('dept_org_cert'))
                ->toMediaCollection('organization_registrations');
        }

        if ($request->hasFile('performance_certificate')) {
            $standardization->addMedia($request->file('performance_certificate'))
                ->toMediaCollection('performance_certificate');
        }

        if ($standardization->save()) {
            Mail::to($standardization->email)->queue(new StandardizationAppliedMail($standardization));
            return redirect()->route('standardizations.create')->with('success', 'Your form has been submitted successfully');
        }
        return redirect()->route('standardizations.create')->with('danger', 'There is an error submitting your data');
    }

    public function approvedProducts(Request $request, $id)
    {
        $product = EStandardization::find($id);
        return view('admin.standardizations.approved', compact('product'));
    }
}
