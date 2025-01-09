<?php

namespace App\Http\Controllers\Site;

use App\Models\Category;
use App\Models\District;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

use App\Models\ContractorMachinery;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Contractor;
use App\Models\ContractorHumanResource;
use App\Mail\Contractor\AppliedMail;
use App\Http\Requests\StoreContractorRequest;

class ContractorController extends Controller
{
    public function registration()
    {
        $cat = [
            'districts' => District::all(),
            'contractor_category' => Category::where('type', 'contractor_category')->get(),
            'provincial_entities' => Category::where('type', 'provincial_entity')->get(),
        ];
        return view('site.contractors.registration', compact('cat'));
    }

    public function store(StoreContractorRequest $request)
    {
        $contractor = new Contractor();
        if ($contractor->where('pec_number', $request->input('pec_number'))->where('status', '!=', 'deffered_three')->exists()) {
            return redirect()->route('admin.contractors.registration')->with('danger', 'User with this PEC Number already exists');
        }
        $contractor->owner_name = $request->input('owner_name');
        $contractor->pec_number = $request->input('pec_number');
        $contractor->cnic = $request->input('cnic');
        $contractor->email = $request->input('email');
        $contractor->password = $request->input('password');
        $contractor->mobile_number = $request->input('mobile_number');

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

    public function checkPEC(Request $request)
    {
        $pecNumber = $request->input('pec_number');
        $exists = Contractor::where('pec_number', $pecNumber)->where('status', '!=', 3)->exists();
        return response()->json(['unique' => !$exists]);
    }

    public function approvedContractors(Request $request, $id)
    {
        $contractor = Contractor::find($id);
        return view('site.contractors.approved', compact('contractor'));
    }

    public function login_view()
    {
        return view('site.contractors.login');
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

    public function dashboard()
    {
        $contractor = Contractor::findOrFail(session('contractor_id'));

        $emptyFields = collect($contractor->toArray())->filter(function ($value) {
            return empty($value) && $value !== '0';
        })->count();

        session()->flash('incomplete_fields', $emptyFields);

        $profile_status = [
            'empty_fields' => $emptyFields,
            'total_fields' => count($contractor->toArray())
        ];

        return view('site.contractors.dashboard', compact('contractor', 'profile_status'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('contractor_id');
        return redirect()->route('contractors.login')->with('status', 'You have been logged out successfully');
    }

    public function edit()
    {
        $contractor = Contractor::findOrFail(session('contractor_id'));
        $cat = [
            'districts' => District::all(),
            'contractor_category' => Category::where('type', 'contractor_category')->get(),
            'provincial_entities' => Category::where('type', 'provincial_entity')->get(),
        ];

        if ($contractor->status !== 'new') {
            return redirect()->route('contractors.dashboard')
                ->with('error', 'You can only edit contractor when status is new');
        }

        return view('site.contractors.edit', compact('contractor', 'cat'));
    }

    public function update(Request $request)
    {
        $contractor = Contractor::findOrFail(session('contractor_id'));

        if ($contractor->status !== 'new') {
            return redirect()->route('contractors.dashboard')
                ->with('error', 'You can only update contractor when status is new');
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

        if ($request->has('pre_enlistment')) {
            $contractor->pre_enlistment = json_encode($request->input('pre_enlistment'));
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

        return redirect()->route('contractors.dashboard')
            ->with('status', 'Contractor updated successfully');
    }

    public function createHrProfiles()
    {
        return view('site.contractors.hr_profile');
    }

    public function storeHrProfile(Request $request)
    {
        $contractor = Contractor::findOrFail(session('contractor_id'));

        $request->validate([
            'hr_profile' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'profiles.*.name' => 'required|string|max:255',
            'profiles.*.cnic_number' => 'required|string|max:15',
            'profiles.*.pec_number' => 'required|string|max:50',
            'profiles.*.designation' => 'nullable|string|max:100',
            'profiles.*.start_date' => 'nullable|date',
            'profiles.*.end_date' => 'nullable|date',
            'profiles.*.salary' => 'nullable|numeric'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->profiles as $profile) {
                $hrProfile = $contractor->humanResources()->create([
                    'name' => $profile['name'],
                    'cnic_number' => $profile['cnic_number'],
                    'pec_number' => $profile['pec_number'],
                    'designation' => $profile['designation'] ?? null,
                    'start_date' => $profile['start_date'] ?? null,
                    'end_date' => $profile['end_date'] ?? null,
                    'salary' => $profile['salary'] ?? null
                ]);

                if ($request->hasFile('hr_profile')) {
                    $hrProfile->addMedia($request->file('hr_profile'))
                        ->toMediaCollection('hr_documents');
                }
            }

            DB::commit();
            return redirect()->back()->with('status', 'HR Profiles saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while saving the profiles.'])
                ->withInput();
        }
    }

    public function createMachinery()
    {
        return view('site.contractors.machinery');
    }

    public function storeMachinery(Request $request)
    {
        $contractor = Contractor::findOrFail(session('contractor_id'));

        $request->validate([
            'machinery_docs' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'machinery.*.name' => 'required|string|max:255',
            'machinery.*.number' => 'required|string|max:50',
            'machinery.*.model' => 'nullable|string|max:100',
            'machinery.*.registration' => 'nullable|string|max:50'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->machinery as $machine) {
                $machinery = $contractor->machinery()->create([
                    'name' => $machine['name'],
                    'number' => $machine['number'],
                    'model' => $machine['model'] ?? null,
                    'registration' => $machine['registration'] ?? null
                ]);

                if ($request->hasFile('machinery_docs')) {
                    $machinery->addMedia($request->file('machinery_docs'))
                        ->toMediaCollection('machinery_documents');
                }
            }

            DB::commit();
            return redirect()->route('contractors.work_experience.create')
                ->with('status', 'Machinery details saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while saving the machinery details.'])
                ->withInput();
        }
    }

    public function createWorkExperience()
    {
        return view('site.contractors.work_experience');
    }

    public function storeWorkExperience(Request $request)
    {
        $contractor = Contractor::findOrFail(session('contractor_id'));

        $request->validate([
            'experience_docs' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'experiences.*.adp_number' => 'required|string|max:50',
            'experiences.*.project_name' => 'required|string|max:255',
            'experiences.*.project_cost' => 'required|numeric',
            'experiences.*.commencement_date' => 'required|date',
            'experiences.*.completion_date' => 'required|date',
            'experiences.*.status' => 'nullable|in:completed,ongoing',
            'experiences.*.work_order' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->experiences as $experience) {
                $workExperience = $contractor->workExperiences()->create([
                    'adp_number' => $experience['adp_number'],
                    'project_name' => $experience['project_name'],
                    'project_cost' => $experience['project_cost'],
                    'commencement_date' => $experience['commencement_date'],
                    'completion_date' => $experience['completion_date'],
                    'status' => $experience['status'] ?? null
                ]);

                if ($request->hasFile('experience_docs')) {
                    $workExperience->addMedia($request->file('experience_docs'))
                        ->toMediaCollection('experience_documents');
                }

                if (isset($experience['work_order']) && $experience['work_order'] instanceof UploadedFile) {
                    $workExperience->addMedia($experience['work_order'])
                        ->toMediaCollection('work_orders');
                }
            }

            DB::commit();
            return redirect()->back()->with('status', 'Work experience saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while saving the work experience.'])
                ->withInput();
        }
    }
}
