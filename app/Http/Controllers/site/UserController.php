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
            ->orderBy('office')
            ->pluck('office');

        $contactsByOffice = $offices->mapWithKeys(function ($office) {
            $contacts = User::select('name', 'designation', 'office', 'mobile_number', 'landline_number', 'facebook', 'twitter', 'whatsapp')
                ->where('office', $office)
                ->orderBy('name')
                ->get();
            return [$office => $contacts];
        });

        return view('site.users.contacts', compact('contactsByOffice'));
    }

    public function showPositions($designation)
    {
        $users = User::where('designation', $designation)
            ->with(['media' => function ($query) {
                $query->whereIn('collection_name', ['profile_pictures', 'posting_orders', 'exit_orders']);
            }])
            ->get();

        $userData = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'title' => $user->title,
                'posting_date' => $user->posting_date ? $user->posting_date->format('j, F Y') : 'N/A',
                'exit_date' => $user->exit_date ? $user->exit_date->format('j, F Y') : 'N/A',
                'profile_pictures' => $user->getFirstMediaUrl('profile_pictures'),
            ];
        });

        return view('site.users.list', compact('userData', 'designation'));
    }

    public function getUserDetails($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        $userData = [
            'id' => $user->id,
            'name' => $user->name ?? 'N/A',
            'cnic' => $user->cnic ?? 'N/A',
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
}
