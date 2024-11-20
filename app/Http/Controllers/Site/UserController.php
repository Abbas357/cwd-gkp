<?php

namespace App\Http\Controllers\Site;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Mail\User\AppliedMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function createCard()
    {
        $cat = [
            'designations' => Category::where('type', 'designation')->get(),
            'offices' => Category::where('type', 'office')->get(),
            'bps' => Category::where('type', 'bps')->get(),
        ];
        return view('site.users.create-card', compact('cat'));
    }

    public function storeCard(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'mark_of_identification' => 'nullable|string|max:255',
            'cnic' => 'required|string|max:15|unique:users,cnic',
            'email' => 'required|email|max:255|unique:users,email',
            'landline_number' => 'nullable|string|max:15',
            'mobile_number' => 'required|string|max:15|unique:users,mobile_number',
            'personnel_number' => 'required|string|max:15|unique:users,personnel_number',
            'blood_group' => 'nullable|string|max:5',
            'emergency_contact' => 'nullable|string|max:15',
            'parmanent_address' => 'required|string|max:255',
            'present_address' => 'required|string|max:255',
            'designation' => 'required|string|max:100',
            'bps' => 'required|string|max:100',
            'office' => 'required|string|max:100',
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->username = strtolower($validatedData['name']) . substr(uniqid(), -4);;
        $user->password = strtolower($validatedData['name']) . '123';
        $user->father_name = $validatedData['father_name'];
        $user->date_of_birth = $validatedData['date_of_birth'];
        $user->mark_of_identification = $validatedData['mark_of_identification'];
        $user->cnic = $validatedData['cnic'];
        $user->email = $validatedData['email'];
        $user->landline_number = $validatedData['landline_number'];
        $user->mobile_number = $validatedData['mobile_number'];
        $user->personnel_number = $validatedData['personnel_number'];
        $user->blood_group = $validatedData['blood_group'];
        $user->emergency_contact = $validatedData['emergency_contact'];
        $user->parmanent_address = $validatedData['parmanent_address'];
        $user->present_address = $validatedData['present_address'];
        $user->designation = $validatedData['designation'];
        $user->bps = $validatedData['bps'];
        $user->office = $validatedData['office'];
        $user->card_status = 'new';

        if ($request->hasFile('profile_picture')) {
            $user->addMedia($request->file('profile_picture'))
                ->toMediaCollection('profile_pictures');
        }

        if ($user->save()) {
            Mail::to($user->email)->queue(new AppliedMail($user));
            return redirect()->route('card.createCard')->with('success', 'Your ID card information has been submitted. We will notify you once your information is verified.');
        }
        return redirect()->route('card.createCard')->with('error', 'There is an error submitting your data');
    }


    public function contacts()
    {
        $offices = User::select('office')
            ->distinct()
            ->pluck('office');

        $contactsByOffice = $offices->sortByDesc(function ($office) {
            $contactWithMaxBps = User::where('office', $office)
                ->orderByDesc('bps')
                ->orderBy('position')
                ->first();

            return [$contactWithMaxBps->bps, $contactWithMaxBps->position];
        })->mapWithKeys(function ($office) {
            $contacts = User::select('name', 'position', 'office', 'bps', 'mobile_number', 'landline_number', 'facebook', 'twitter', 'whatsapp')
                ->where('office', $office)
                ->orderByDesc('bps')
                ->orderBy('position')
                ->orderBy('name')
                ->get();

            return [$office => $contacts];
        });

        return view('site.users.contacts', compact('contactsByOffice'));
    }

    public function showPositions($position)
    {
        $users = User::withoutGlobalScope('active')->where('is_active', 0)->where('position', $position)
            ->with(['media' => function ($query) {
                $query->whereIn('collection_name', ['profile_pictures']);
            }])
            ->get();

        $userData = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'title' => $user->title,
                'is_active' => $user->is_active,
                'from' => $user->posting_date?->format('j, F Y'),
                'to' => $user->exit_date?->format('j, F Y'),
                'profile_pictures' => $user->getFirstMediaUrl('profile_pictures', 'small')
                    ?: asset('admin/images/default-avatar.jpg'),
            ];
        });

        return view('site.users.list', compact('userData', 'position'));
    }

    public function getUserDetails($id)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        $userData = [
            'id' => $user->id,
            'name' => $user->name ?? 'N/A',
            'email' => $user->email ?? 'N/A',
            'mobile_number' => $user->mobile_number ?? 'N/A',
            'landline_number' => $user->landline_number ?? 'N/A',
            'whatsapp' => $user->whatsapp ?? 'N/A',
            'facebook' => $user->facebook ?? 'N/A',
            'twitter' => $user->twitter ?? 'N/A',
            'designation' => $user->designation ?? 'N/A',
            'title' => $user->title ?? 'N/A',
            'posting_type' => $user->posting_type ?? 'N/A',
            'posting_date' => $user->posting_date ? $user->posting_date->format('j, F Y') : 'N/A',
            'exit_type' => $user->exit_type ?? 'N/A',
            'exit_date' => $user->exit_date ? $user->exit_date->format('j, F Y') : 'N/A',
            'is_active' => $user->is_active,
            'media' => [
                'profile_pictures' => $user->getFirstMediaUrl('profile_pictures', 'small')
                    ?: asset('admin/images/default-avatar.jpg'),
                'posting_orders' => $user->getFirstMediaUrl('posting_orders'),
                'exit_orders' => $user->getFirstMediaUrl('exit_orders'),
            ],
        ];

        $html = view('site.users.partials.detail', ['user' => $userData])->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function team()
    {
        $roles = [
            'Chief Engineers' => ['column' => 'designation', 'value' => 'Chief Engineer'],
            'Additional Secretaries' => ['column' => 'designation', 'value' => 'Additional Secretary'],
            'Directors' => ['column' => 'designation', 'value' => 'Director'],
            'Deputy Secretaries' => ['column' => 'designation', 'value' => 'Deputy Secretary'],
            'Principal Consulting Architect' => ['column' => 'position', 'value' => 'Principal Consulting Architect'],
            'IT Professionals' => ['column' => 'office', 'value' => 'Director (IT)'],
        ];

        $teamData = [];

        foreach ($roles as $role => $criteria) {
            $teamData[$role] = User::select('id', 'name', 'title', 'position', 'bps')
                ->where($criteria['column'], $criteria['value'])
                ->with('media')
                ->latest('created_at')
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'title' => $user->title ?? 'N/A',
                        'position' => $user->position ?? 'N/A',
                        'facebook' => $user->facebook ?? '#',
                        'twitter' => $user->twitter ?? '#',
                        'whatsapp' => $user->whatsapp ?? '#',
                        'mobile_number' => $user->mobile_number ?? '#',
                        'landline_number' => $user->landline_number ?? '#',
                        'image' => $user->getFirstMediaUrl('profile_pictures', 'small')
                            ?: asset('admin/images/default-avatar.jpg'),
                    ];
                });
        }

        return view('site.users.team', compact('teamData'));
    }

    public function verifiedUsers(Request $request, $id)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($id);
        return view('site.users.verified', compact('user'));
    }
}
