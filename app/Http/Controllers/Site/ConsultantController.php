<?php

namespace App\Http\Controllers\Site;

use App\Models\District;
use App\Models\Consultant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreConsultantRequest;

class ConsultantController extends Controller
{
    public function dashboard()
    {
        $consultant = Consultant::findOrFail(session('consultant_id'));
        return view('site.consultants.dashboard', compact('consultant'));
    }

    public function register()
    {
        $cat = [
            'districts' => District::all(),
            'sectors' => ['Road', 'Building', 'Bridge'],
        ];

        return view('site.consultants.auth.register', compact('cat'));
    }

    public function view_login()
    {
        return view('site.consultants.auth.login');
    }

    public function login(Request $request)
    {
        if (session()->has('consultant_id')) {
            return redirect()->route('consultants.dashboard')->with([
                'error' => 'You are already logged in',
            ]);
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $consultant = Consultant::where('email', $credentials['email'])->first();

        if ($consultant && Hash::check($credentials['password'], $consultant->password)) {
            session(['consultant_id' => $consultant->id]);
            return redirect()->route('consultants.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    public function store(StoreConsultantRequest $request)
    {
        $consultant = new Consultant();
        $consultant->uuid = Str::uuid();
        $consultant->name = $request->input('firm_name');
        $consultant->email = $request->input('email');
        $consultant->pec_number = $request->input('pec_number');
        $consultant->contact_number = $request->input('contact_number');
        $consultant->district = $request->input('district');
        $consultant->sector = $request->input('sector');
        $consultant->address = $request->input('address');
        $consultant->password = $request->input('email');

        if ($consultant->save()) {
            session(['consultant_id' => $consultant->id]);
            return redirect()->route('consultants.dashboard')->with('success', 'Congratulations! Your account has been created successfully. The email ' . $request->input('email') . ' has been set as your password for managing your account in future.');
        }

        return redirect()->route('consultants.login')->with('error', 'There is an error submitting your data');
    }

    public function PasswordView()
    {
        return view('site.consultants.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $consultant = Consultant::findOrFail(session('consultant_id'));
        if (!Hash::check($request->input('old_password'), $consultant->password)) {
            return back()->with(['error' => 'The old password is incorrect.']);
        }

        $consultant->password = $request->input('new_password');
        $consultant->save();

        return back()->with('success', 'Password updated successfully.');
    }

    public function edit()
    {
        $consultant = Consultant::findOrFail(session('consultant_id'));
        $cat = [
            'districts' => District::all(),
        ];

        return view('site.consultants.edit', compact('consultant', 'cat'));
    }

    public function update(Request $request)
    {
        $consultant = Consultant::findOrFail(session('consultant_id'));
        
        Validator::extend('email_exists', function ($attribute, $value, $parameters, $validator) {
            $domain = substr(strrchr($value, "@"), 1);
            return checkdnsrr($domain, "MX");
        });
        
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'firm_name' => 'required|string|max:100',
            'cnic' => [
                'required',
                'string',
                'max:15',
                'regex:/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/'
            ],
            'mobile_number' => [
                'required',
                'string',
                'max:45',
                'regex:/^((\+92|92|0)([0-9]{3}|[0-9]{3}-)[0-9]{7}|(\+92|92|0)[0-9]{10})$/'
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                'email_exists'
            ],
            'address' => 'required|string',
            'district' => 'required|string|max:100',
        ]);

        if ($consultant->updated_at && $consultant->updated_at->isToday()) {
            return redirect()->route('standardizations.edit')
                ->with('error', 'Update Failed! Come back tomorrow to update your profile again');
        }

        $consultant->update($validated);

        if ($request->hasFile('consultant_picture')) {
            $consultant->addMedia($request->file('consultant_picture'))->toMediaCollection('consultant_pictures');
        }

        if ($request->hasFile('cnic_front')) {
            $consultant->addMedia($request->file('cnic_front'))->toMediaCollection('consultant_cnic_front');
        }

        if ($request->hasFile('cnic_back')) {
            $consultant->addMedia($request->file('cnic_back'))->toMediaCollection('consultant_cnic_back');
        }
        
        return redirect()->route('consultants.edit')
            ->with('status', 'Profile Updated');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('consultant_id');
        return redirect()->route('consultants.login.get')->with('status', 'You have been logged out successfully');
    }

    public function checkFields(Request $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');
        $consultantId = session('consultant_id');

        $query = Consultant::query();
        
        if ($consultantId) {
            $query->where('id', '!=', $consultantId);
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
