<?php

namespace App\Http\Controllers\Site;

use App\Models\District;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Standardization;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Standardization\AppliedMail;
use App\Http\Requests\StoreStandardizationRequest;

class StandardizationController extends Controller
{
    public function dashboard()
    {
        $standardization = Standardization::findOrFail(session('standardization_id'));
        return view('site.standardizations.dashboard', compact('standardization'));
    }

    public function register()
    {
        $cat = [
            'districts' => District::all(),
        ];

        return view('site.standardizations.auth.register', compact('cat'));
    }

    public function view_login()
    {
        return view('site.standardizations.auth.login');
    }

    public function login(Request $request)
    {
        if (session()->has('standardization_id')) {
            return redirect()->route('standardizations.dashboard')->with([
                'error' => 'You are already logged in',
            ]);
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $standardization = Standardization::where('email', $credentials['email'])->first();

        if ($standardization && Hash::check($credentials['password'], $standardization->password)) {
            session(['standardization_id' => $standardization->id]);
            return redirect()->route('standardizations.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }
    
    public function store(StoreStandardizationRequest $request)
    {
        $standardization = new Standardization();
        $standardization->uuid = Str::uuid();
        $standardization->firm_name = $request->input('firm_name');
        $standardization->owner_name = $request->input('owner_name');
        $standardization->address = $request->input('address');
        $standardization->cnic = $request->input('cnic');
        $standardization->district = $request->input('district');
        $standardization->mobile_number = $request->input('mobile_number');
        $standardization->email = $request->input('email');
        $standardization->password = $request->input('password');

        if ($request->hasFile('firm_picture')) {
            $standardization->addMedia($request->file('firm_picture'))
                ->toMediaCollection('standardization_firms_pictures');
        }

        if ($standardization->save()) {
            session(['standardization_id' => $standardization->id]);
            return redirect()->route('standardizations.dashboard')->with('success', 'Congratulation! Account successfully created. Please use this portal for managing your account.');
        }
        return redirect()->route('standardizations.create')->with('danger', 'There is an error submitting your data');
    }

    public function edit()
    {
        $standardization = Standardization::findOrFail(session('standardization_id'));
        $cat = [
            'districts' => District::all(),
        ];

        return view('site.standardizations.edit', compact('standardization', 'cat'));
    }

    public function uploadDocsView()
    {
        $standardization = Standardization::findOrFail(session('standardization_id'));

        return view('site.standardizations.upload', compact('standardization'));
    }

    public function uploadDocs(Request $request)
    {
        $standardization = Standardization::findOrFail(session('standardization_id'));

        $documents = [
            'secp_certificate' => 'secp_certificates',
            'iso_certificate' => 'iso_certificates',
            'commerce_membership' => 'commerse_memberships',
            'pec_certificate' => 'pec_certificates',
            'annual_tax_returns' => 'annual_tax_returns',
            'audited_financial' => 'audited_financials',
            'dept_org_cert' => 'organization_registrations',
            'performance_certificate' => 'performance_certificate',
        ];

        foreach ($documents as $field => $collection) {
            if ($request->hasFile($field)) {
                $standardization->addMedia($request->file($field))->toMediaCollection($collection);
            }
        }

        return redirect()->route('standardizations.upload')->with('success', 'Documents uploaded successfully.');
    }

    public function update(Request $request)
    {
        $standardization = Standardization::findOrFail(session('standardization_id'));
        $validated = $request->validate([
            'owner_name' => 'required|string|max:100',
            'firm_name' => 'required|string|max:100',
            'cnic' => 'required|string|max:45',
            'mobile_number' => 'required|string|max:45',
            'email' => 'required|email|max:100',
            'address' => 'required|string',
            'district' => 'required|string|max:100',
        ]);

        if ($standardization->updated_at && $standardization->updated_at->isToday()) {
            return redirect()->route('standardizations.edit')
                ->with('error', 'Update Failed! Come back tomorrow to update your profile again');
        }

        $standardization->update($validated);

        if ($request->hasFile('firm_picture')) {
            $standardization->addMedia($request->file('firm_picture'))->toMediaCollection('standardization_firms_pictures');
        }
        
        return redirect()->route('standardizations.edit')
            ->with('status', 'Profile Updated');
    }

    public function PasswordView()
    {
        return view('site.standardizations.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $standardization = Standardization::findOrFail(session('standardization_id'));
        if (!Hash::check($request->input('old_password'), $standardization->password)) {
            return back()->with(['error' => 'The old password is incorrect.']);
        }

        $standardization->password = $request->input('new_password');
        $standardization->save();

        return back()->with('success', 'Password updated successfully.');
    }

    public function approvedProducts(Request $request, $uuid)
    {
        $Standardization = Standardization::where('uuid', $uuid)->first();
        $products = $Standardization->products()->where('status', 'approved')->get();

        return view('site.standardizations.approved', compact('Standardization', 'products'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('standardization_id');
        return redirect()->route('standardizations.login.get')->with('status', 'You have been logged out successfully');
    }

    public function checkFields(Request $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');
        $standardizationId = session('standardization_id');

        $query = Standardization::query();
        
        if ($standardizationId) {
            $query->where('id', '!=', $standardizationId);
        }

        $exists = $query->where($field, $value)->exists();

        $messages = [
            'email' => 'This email is already registered',
            'cnic' => 'This CNIC is already registered',
            'mobile_number' => 'This mobile number is already registered'
        ];

        return response()->json([
            'valid' => !$exists,
            'message' => $exists ? $messages[$field] : ''
        ]);
    }
}
