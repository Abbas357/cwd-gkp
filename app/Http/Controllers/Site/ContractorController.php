<?php

namespace App\Http\Controllers\Site;

use App\Models\District;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Contractor;
use App\Mail\Contractor\AppliedMail;
use App\Http\Requests\StoreContractorRequest;

class ContractorController extends Controller
{
    public function dashboard()
    {
        $contractor = Contractor::findOrFail(session('contractor_id'));
        return view('site.contractors.dashboard', compact('contractor'));
    }

    public function register()
    {
        $cat = [
            'districts' => District::all(),
        ];

        return view('site.contractors.auth.register', compact('cat'));
    }

    public function view_login()
    {
        return view('site.contractors.auth.login');
    }

    public function login(Request $request)
    {
        if (session()->has('contractor_id')) {
            return redirect()->route('contractors.dashboard')->with([
                'error' => 'You are already logged in',
            ]);
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $contractor = Contractor::where('email', $credentials['email'])->first();

        if ($contractor && Hash::check($credentials['password'], $contractor->password)) {
            session(['contractor_id' => $contractor->id]);
            return redirect()->route('contractors.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    public function store(StoreContractorRequest $request)
    {
        $contractor = new Contractor();
        $contractor->name = $request->input('name');
        $contractor->firm_name = $request->input('firm_name');
        $contractor->email = $request->input('email');
        $contractor->cnic = $request->input('cnic');
        $contractor->address = $request->input('address');
        $contractor->district = $request->input('district');
        $contractor->mobile_number = $request->input('mobile_number');
        $contractor->password = $request->input('password');

        if ($contractor->save()) {
            session(['contractor_id' => $contractor->id]);
            $successMessage = view('site.contractors.partials.success_message', [
                'email' => $contractor->email,
                'password' => $request->input('password'),
            ])->render();

            return redirect()->route('contractors.dashboard')->with('success', $successMessage);
        }

        return redirect()->route('contractors.login')->with('error', 'There is an error submitting your data');
    }

    public function PasswordView()
    {
        return view('site.contractors.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $contractor = Contractor::findOrFail(session('contractor_id'));
        if (!Hash::check($request->input('old_password'), $contractor->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        $contractor->password = $request->input('new_password');
        $contractor->save();

        return back()->with('status', 'Password updated successfully.');
    }

    public function approvedContractors(Request $request, $id)
    {
        $contractor = Contractor::find($id);
        return view('site.contractors.approved', compact('contractor'));
    }

    public function edit()
    {
        $contractor = Contractor::findOrFail(session('contractor_id'));
        $cat = [
            'districts' => District::all(),
        ];

        return view('site.contractors.edit', compact('contractor', 'cat'));
    }

    public function update(Request $request)
    {
        $contractor = Contractor::findOrFail(session('contractor_id'));
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'firm_name' => 'required|string|max:100',
            'cnic' => 'required|string|max:45',
            'mobile_number' => 'required|string|max:45',
            'email' => 'required|email|max:100',
            'address' => 'required|string',
            'district' => 'required|string|max:100',
        ]);

        $contractor->update($validated);

        if ($request->hasFile('contractor_picture')) {
            $contractor->addMedia($request->file('contractor_picture'))->toMediaCollection('contractor_pictures');
        }

        if ($request->hasFile('cnic_front')) {
            $contractor->addMedia($request->file('cnic_front'))->toMediaCollection('contractor_cnic');
        }

        if ($request->hasFile('cnic_back')) {
            $contractor->addMedia($request->file('cnic_back'))->toMediaCollection('contractor_cnic');
        }
        
        return redirect()->route('contractors.edit')
            ->with('status', 'Profile Updated');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('contractor_id');
        return redirect()->route('contractors.login')->with('status', 'You have been logged out successfully');
    }
}
