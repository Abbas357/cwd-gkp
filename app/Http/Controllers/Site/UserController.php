<?php

namespace App\Http\Controllers\Site;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function contacts()
    {
        $offices = User::select('office')
            ->distinct()
            ->pluck('office');

        $contactsByOffice = $offices->sortByDesc(function ($office) {
            $contactWithMaxBps = User::where('office', $office)
                ->orderByDesc('bps')
                ->orderBy('designation')
                ->first();

            return [$contactWithMaxBps->bps, $contactWithMaxBps->designation];
        })->mapWithKeys(function ($office) {
            $contacts = User::select('name', 'designation', 'office', 'bps', 'mobile_number', 'landline_number', 'facebook', 'twitter', 'whatsapp')
                ->where('office', $office)
                ->orderByDesc('bps')
                ->orderBy('designation')
                ->orderBy('name')
                ->get();

            return [$office => $contacts];
        });

        return view('site.users.contacts', compact('contactsByOffice'));
    }

    public function showPositions($designation)
    {
        $users = User::withoutGlobalScope('active')->where('designation', $designation)
            ->with(['media' => function ($query) {
                $query->whereIn('collection_name', ['profile_pictures']);
            }])
            ->get();

        $userData = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'title' => $user->title,
                'profile_pictures' => $user->getFirstMediaUrl('profile_pictures'),
            ];
        });

        return view('site.users.list', compact('userData', 'designation'));
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
                    ?: asset('admin/images/no-profile.png'),
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
        $users = User::select('id', 'name', 'title', 'designation', 'bps')
            ->whereIn('bps', ['BPS-18', 'BPS-19', 'BPS-20'])
            ->with('media')
            ->latest('created_at')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'title' => $user->title ?? 'N/A',
                    'designation' => $user->designation ?? 'N/A',
                    'facebook' => $user->facebook ?? '#',
                    'twitter' => $user->twitter ?? '#',
                    'whatsapp' => $user->whatsapp ?? '#',
                    'mobile_number' => $user->mobile_number ?? '#',
                    'landline_number' => $user->landline_number ?? '#',
                    'image' => $user->getFirstMediaUrl('profile_pictures', 'small')
                        ?: asset('admin/images/no-profile.png')
                ];
            });

        return view('site.users.team', compact('users'));
    }
}
