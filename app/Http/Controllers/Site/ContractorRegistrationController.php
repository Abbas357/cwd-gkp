<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\District;
use App\Models\ContractorRegistration;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContractorRegistration\AppliedMail;
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
        if ($registration->where('pec_number', $request->input('pec_number'))->where('status', '!=', 'deffered_three')->exists()) {
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
        $registration->password = $this->generatePassword($registration->email);
        $registration->mobile_number = $request->input('mobile_number');
        $registration->is_limited = $request->input('is_limited');
        
        if ($request->has('pre_enlistment')) {
            $registration->pre_enlistment = json_encode($request->input('pre_enlistment'));
        }

        $this->handleMediaAttachments($registration, $request);

        if ($registration->save()) {
            // Mail::to($registration->email)->queue(new AppliedMail($registration));
        
            $successMessage = view('site.cont_registrations.partials.success_message', [
                'email' => $registration->email,
                'password' => $registration->password,
                'loginUrl' => route('registrations.login')
            ])->render();
        
            return redirect()->route('registrations.create')->with('success', $successMessage);
        }
        
        return redirect()->route('registrations.create')->with('danger', 'There is an error submitting your data');
    }

    private function handleMediaAttachments($registration, $request)
    {
        if ($request->hasFile('contractor_picture')) {
            $registration->addMedia($request->file('contractor_picture'))->toMediaCollection('contractor_pictures');
        }

        $attachments = [
            'cnic_front_attachment' => 'cnic_front_attachments',
            'cnic_back_attachment' => 'cnic_back_attachments',
            'fbr_attachment' => 'fbr_attachments',
            'kpra_attachment' => 'kpra_attachments',
            'pec_attachment' => 'pec_attachments',
            'form_h_attachment' => 'form_h_attachments',
            'pre_enlistment_attachment' => 'pre_enlistment_attachments'
        ];

        foreach ($attachments as $input => $collection) {
            if ($request->hasFile($input)) {
                $registration->addMedia($request->file($input))->toMediaCollection($collection);
            }
        }
    }

    private function generatePassword($email)
    {
        $email_prefix = strstr($email, '@', true);
        $random_number = rand(100000, 999999);
        return "{$email_prefix}#{$random_number}";
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
        return view('site.cont_registrations.approved', compact('registration'));
    }

    public function login_view()
    {
        return view('site.cont_registrations.login');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('site.cont_registrations.login');
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $contractor = ContractorRegistration::where('email', $credentials['email'])->first();

        if ($contractor && $credentials['password'] === $contractor->password) {
            session(['contractor_id' => $contractor->id]);
            return redirect()->route('registrations.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    public function dashboard()
    {
        $contractor = ContractorRegistration::findOrFail(session('contractor_id'));
        return view('site.cont_registrations.dashboard', compact('contractor'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('contractor_id');
        return redirect()->route('registrations.login')->with('status', 'You have been logged out successfully');
    }

    public function edit()
    {
        $contractor = ContractorRegistration::findOrFail(session('contractor_id'));
        
        if ($contractor->status !== 'new') {
            return redirect()->route('registrations.dashboard')
                ->with('error', 'You can only edit registration when status is new');
        }
        
        return view('site.cont_registrations.edit', compact('contractor'));
    }

    public function update(Request $request)
    {
        $contractor = ContractorRegistration::findOrFail(session('contractor_id'));
        
        if ($contractor->status !== 'new') {
            return redirect()->route('registrations.dashboard')
                ->with('error', 'You can only update registration when status is new');
        }

        $validated = $request->validate([
            'owner_name' => 'required|string|max:100',
            'contractor_name' => 'required|string|max:100',
            'cnic' => 'required|string|max:45',
            'mobile_number' => 'nullable|string|max:45',
            'email' => 'required|email|max:100',
            'address' => 'nullable|string',
            'district' => 'required|string|max:100',
            'pec_number' => 'required|string|max:100',
            'pec_category' => 'required|string|max:45',
            'category_applied' => 'required|string|max:45',
            'fbr_ntn' => 'nullable|string|max:45',
            'kpra_reg_no' => 'nullable|string|max:45',
            'is_limited' => 'required|in:yes,no',
            'contractor_picture' => 'nullable|image|max:2048',
            'cnic_front_attachment' => 'nullable|file|max:2048',
            'cnic_back_attachment' => 'nullable|file|max:2048',
            'fbr_attachment' => 'nullable|file|max:2048',
            'kpra_attachment' => 'nullable|file|max:2048',
            'pec_attachment' => 'nullable|file|max:2048',
        ]);

        $contractor->update($validated);

        if ($request->hasFile('contractor_picture')) {
            $contractor->addMedia($request->file('contractor_picture'))->toMediaCollection('contractor_pictures');
        }
        
        $attachments = [
            'cnic_front_attachment' => 'cnic_front_attachments',
            'cnic_back_attachment' => 'cnic_back_attachments',
            'fbr_attachment' => 'fbr_attachments',
            'kpra_attachment' => 'kpra_attachments',
            'pec_attachment' => 'pec_attachments',
        ];

        foreach ($attachments as $input => $collection) {
            if ($request->hasFile($input)) {
                $contractor->addMedia($request->file($input))->toMediaCollection($collection);
            }
        }

        return redirect()->route('registrations.dashboard')
            ->with('status', 'Registration updated successfully');
    }
}
