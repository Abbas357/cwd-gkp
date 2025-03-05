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
            ->featuredOnContactOffice()
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
                ->featuredOnContact()
                ->orderByDesc('bps')
                ->orderBy('position')
                ->orderBy('name')
                ->get();

            return [$office => $contacts];
        });

        return view('site.users.contacts', compact('contactsByOffice'));
    }

    private function showPositions($position)
    {
        $users = User::withoutGlobalScope('active')->where('status', 'Archived')->where('position', $position)
            ->with(['media' => function ($query) {
                $query->whereIn('collection_name', ['profile_pictures']);
            }])
            ->get();

        $userData = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'uuid' => $user->uuid,
                'name' => $user->name,
                'title' => $user->title,
                'status' => $user->status,
                'from' => $user->posting_date?->format('j, F Y'),
                'to' => $user->exit_date?->format('j, F Y'),
                'profile_pictures' => $user->getFirstMediaUrl('profile_pictures', 'small')
                    ?: asset('admin/images/default-avatar.jpg'),
            ];
        });

        return $userData;
    }

    public function getUserDetails($uuid)
    {
        $user = User::withoutGlobalScope('active')->where('uuid', $uuid)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        $userData = [
            'id' => $user->id,
            'name' => $user->name ?? '-',
            'uuid' => $user->uuid ?? '-',
            'email' => $user->email ?? '-',
            'mobile_number' => $user->mobile_number ?? '-',
            'landline_number' => $user->landline_number ?? '-',
            'whatsapp' => $user->whatsapp ?? '-',
            'facebook' => $user->facebook ?? '-',
            'twitter' => $user->twitter ?? '-',
            'designation' => $user->designation ?? '-',
            'position' => $user->position ?? '-',
            'title' => $user->title ?? '-',
            'posting_type' => $user->posting_type ?? '-',
            'posting_date' => $user->posting_date ? $user->posting_date->format('j, F Y') : '-',
            'exit_type' => $user->exit_type ?? '-',
            'exit_date' => $user->exit_date ? $user->exit_date->format('j, F Y') : '-',
            'status' => $user->status,
            'media' => [
                'profile_pictures' => $user->getFirstMediaUrl('profile_pictures', 'small')
                    ?: asset('admin/images/default-avatar.jpg'),
                'posting_orders' => $user->getFirstMediaUrl('posting_orders'),
                'exit_orders' => $user->getFirstMediaUrl('exit_orders'),
            ],
            'previous' => $this->showPositions($user->position),
            'views_count' => $user->views_count,
        ];

        $this->incrementViews($user);

        return view('site.users.detail', ['user' => $userData]);
    }

    public function team()
    {
        $roles = [
            'Chief Engineers' => ['column' => 'designation', 'value' => 'Chief Engineer'],
            'Additional Secretaries' => ['column' => 'designation', 'value' => 'Additional Secretary'],
            'Directors' => ['column' => 'designation', 'value' => 'Director'],
            'Deputy Secretaries' => ['column' => 'designation', 'value' => 'Deputy Secretary'],
            'Principal Consulting Architect' => ['column' => 'position', 'value' => 'Principal Consulting Architect'],
            'Section Officers' => ['column' => 'designation', 'value' => 'Section Officer'],
            'Administrative Officers' => ['column' => 'designation', 'value' => 'Administrative Officer'],
            'IT Officers' => [
                'custom_query' => true,
                'callback' => function ($query) {
                    return $query->where(function ($q) {
                        $q->where('position', 'LIKE', '%(IT)%')
                        ->orWhere('position', 'LIKE', '%(GIS)%');
                    })
                    ->where(function ($q) {
                        $q->where('BPS', 'BPS-17')
                        ->orWhere('bps', 'BPS-18');
                    });
                }
            ],
        ];

        $teamData = [];

        foreach ($roles as $role => $criteria) {
            $query = User::select('id', 'uuid', 'name', 'title', 'position', 'bps')
                ->featuredOnTeam()
                ->with('media');

            if (isset($criteria['custom_query']) && $criteria['custom_query']) {
                $query = $criteria['callback']($query);
            } else {
                $query = $query->where($criteria['column'], $criteria['value']);
            }

            $teamData[$role] = $query->latest('created_at')
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'uuid' => $user->uuid,
                        'name' => $user->name,
                        'title' => $user->title ?? '-',
                        'position' => $user->position ?? '-',
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
}
