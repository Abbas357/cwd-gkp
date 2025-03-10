<?php

namespace App\Http\Controllers\Site;

use App\Models\User;
use App\Models\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function contacts()
    {
        $offices = Office::whereHas('postings.user.profile', function ($query) {
            $query->whereJsonContains('featured_on', 'ContactOffice');
        })->get();

        $contactsByOffice = $offices->sortByDesc(function ($office) {
            // Get the highest BPS user in this office
            $topUser = User::whereHas('currentPosting', function ($query) use ($office) {
                $query->where('office_id', $office->id);
            })
                ->whereHas('currentDesignation', function ($query) {
                    $query->orderByDesc('bps');
                })
                ->whereHas('profile', function ($query) {
                    $query->whereJsonContains('featured_on', 'Contact');
                })
                ->with(['currentDesignation', 'profile'])
                ->first();

            return $topUser ? (is_numeric($topUser->currentDesignation->bps) ? $topUser->currentDesignation->bps : 0) : 0;
        })->mapWithKeys(function ($office) {
            // Get all featured contacts for this office
            $contacts = User::whereHas('currentPosting', function ($query) use ($office) {
                $query->where('office_id', $office->id);
            })
                ->whereHas('profile', function ($query) {
                    $query->whereJsonContains('featured_on', 'Contact');
                })
                ->with(['profile', 'currentDesignation', 'currentOffice'])
                ->get()
                ->sortByDesc(function ($user) {
                    return $user->currentDesignation ?
                        (is_numeric($user->currentDesignation->bps) ? $user->currentDesignation->bps : 0) : 0;
                })
                ->map(function ($user) {
                    // Transform to match the expected format in the view
                    return (object) [
                        'name' => $user->name,
                        'position' => $user->currentDesignation ? $user->currentDesignation->name : 'N/A',
                        'office' => $user->currentOffice ? $user->currentOffice->name : 'N/A',
                        'bps' => $user->currentDesignation ? $user->currentDesignation->bps : null,
                        'mobile_number' => $user->profile ? $user->profile->mobile_number : null,
                        'landline_number' => $user->profile ? $user->profile->landline_number : null,
                        'facebook' => $user->profile ? $user->profile->facebook : null,
                        'twitter' => $user->profile ? $user->profile->twitter : null,
                        'whatsapp' => $user->profile ? $user->profile->whatsapp : null,
                    ];
                });

            return [$office->name => $contacts];
        });

        return view('site.users.contacts', compact('contactsByOffice'));
    }

    private function showPositions($position)
    {
        $users = User::withoutGlobalScope('active')
            ->where('status', 'Archived')
            ->whereHas('postings', function ($query) use ($position) {
                $query->whereHas('designation', function ($q) use ($position) {
                    $q->where('name', $position);
                });
            })
            ->with(['profile', 'postings' => function ($query) use ($position) {
                $query->with('designation')
                    ->whereHas('designation', function ($q) use ($position) {
                        $q->where('name', $position);
                    });
            }, 'media' => function ($query) {
                $query->whereIn('collection_name', ['profile_pictures']);
            }])
            ->get();

        $userData = $users->map(function ($user) {
            // Get the relevant posting for this position
            $relevantPosting = $user->postings->first();

            return [
                'id' => $user->id,
                'uuid' => $user->uuid,
                'name' => $user->name,
                'title' => $relevantPosting->designation->name ?? null,
                'status' => $user->status,
                'from' => $relevantPosting->start_date ? $relevantPosting->start_date->format('j, F Y') : null,
                'to' => $relevantPosting->end_date ? $relevantPosting->end_date->format('j, F Y') : null,
                'profile_pictures' => $user->getFirstMediaUrl('profile_pictures', 'small')
                    ?: asset('admin/images/default-avatar.jpg'),
            ];
        });

        return $userData;
    }

    /**
     * Get detailed user information
     */
    public function getUserDetails($uuid)
    {
        $user = User::withoutGlobalScope('active')
            ->where('uuid', $uuid)
            ->with(['profile', 'currentPosting.designation', 'currentPosting.office', 'postings' => function ($query) {
                $query->with(['designation', 'office'])->orderBy('start_date', 'desc');
            }, 'media'])
            ->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        // Get current posting info
        $currentPosting = $user->currentPosting;

        // Get profile info
        $profile = $user->profile;

        $userData = [
            'id' => $user->id,
            'name' => $user->name ?? '-',
            'uuid' => $user->uuid ?? '-',
            'email' => $user->email ?? '-',
            'mobile_number' => $profile->mobile_number ?? '-',
            'landline_number' => $profile->landline_number ?? '-',
            'whatsapp' => $profile->whatsapp ?? '-',
            'facebook' => $profile->facebook ?? '-',
            'twitter' => $profile->twitter ?? '-',
            'designation' => $currentPosting ? $currentPosting->designation->name ?? '-' : '-',
            'position' => $currentPosting ? $currentPosting->designation->name ?? '-' : '-', // Using designation name as position
            'title' => $currentPosting ? $currentPosting->designation->name ?? '-' : '-', // Title can be same as designation
            'posting_type' => $currentPosting ? $currentPosting->type ?? '-' : '-',
            'posting_date' => $currentPosting && $currentPosting->start_date ? $currentPosting->start_date->format('j, F Y') : '-',
            'exit_type' => $user->postings->where('is_current', false)->where('type', 'Retirement')->first() ? 'Retirement' : ($user->postings->where('is_current', false)->where('type', 'Termination')->first() ? 'Termination' : '-'),
            'exit_date' => $user->postings->where('is_current', false)->sortByDesc('end_date')->first()?->end_date?->format('j, F Y') ?? '-',
            'status' => $user->status,
            'media' => [
                'profile_pictures' => $user->getFirstMediaUrl('profile_pictures', 'small')
                    ?: asset('admin/images/default-avatar.jpg'),
                'posting_orders' => $currentPosting && $currentPosting->getFirstMediaUrl('posting_orders') ?
                    $currentPosting->getFirstMediaUrl('posting_orders') : '',
                'exit_orders' => $user->postings->where('is_current', false)->sortByDesc('end_date')->first()?->getFirstMediaUrl('exit_orders') ?? '',
            ],
            'previous' => $currentPosting ? $this->showPositions($currentPosting->designation->name) : [],
            'views_count' => $profile->views_count ?? 0,
        ];

        $this->incrementViews($user->profile, 'views_count', 'user_profile');

        return view('site.users.detail', ['user' => $userData]);
    }

    /**
     * Display team page
     */
    public function team()
    {
        $roles = [
            'Chief Engineers' => ['designation' => 'Chief Engineer'],
            'Additional Secretaries' => ['designation' => 'Additional Secretary'],
            'Directors' => ['designation' => 'Director'],
            'Deputy Secretaries' => ['designation' => 'Deputy Secretary'],
            'Principal Consulting Architect' => ['designation' => 'Principal Consulting Architect'],
            'Section Officers' => ['designation' => 'Section Officer'],
            'Administrative Officers' => ['designation' => 'Administrative Officer'],
            'IT Officers' => [
                'custom_query' => true,
                'callback' => function ($query) {
                    return $query->whereHas('currentDesignation', function ($q) {
                        $q->where('name', 'LIKE', '%(IT)%')
                            ->orWhere('name', 'LIKE', '%(GIS)%');
                    })
                        ->whereHas('currentDesignation', function ($q) {
                            $q->where('bps', 'BPS-17')
                                ->orWhere('bps', 'BPS-18');
                        });
                }
            ],
        ];

        $teamData = [];

        foreach ($roles as $role => $criteria) {
            $query = User::select('id', 'uuid', 'name')
                ->where('status', 'Active')
                ->whereHas('profile', function ($q) {
                    $q->whereJsonContains('featured_on', 'Team');
                })
                ->with(['profile', 'currentPosting.designation', 'currentPosting.office', 'media']);

            if (isset($criteria['custom_query']) && $criteria['custom_query']) {
                $query = $criteria['callback']($query);
            } else {
                $query->whereHas('currentDesignation', function ($q) use ($criteria) {
                    $q->where('name', $criteria['designation']);
                });
            }

            $teamData[$role] = $query->latest('created_at')
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'uuid' => $user->uuid,
                        'name' => $user->name,
                        'title' => $user->currentPosting && $user->currentPosting->designation ?
                            $user->currentPosting->designation->name : '-',
                        'position' => $user->currentPosting && $user->currentPosting->designation ?
                            $user->currentPosting->designation->name : '-',
                        'facebook' => $user->profile ? $user->profile->facebook ?? '#' : '#',
                        'twitter' => $user->profile ? $user->profile->twitter ?? '#' : '#',
                        'whatsapp' => $user->profile ? $user->profile->whatsapp ?? '#' : '#',
                        'mobile_number' => $user->profile ? $user->profile->mobile_number ?? '#' : '#',
                        'landline_number' => $user->profile ? $user->profile->landline_number ?? '#' : '#',
                        'image' => $user->getFirstMediaUrl('profile_pictures', 'small')
                            ?: asset('admin/images/default-avatar.jpg'),
                    ];
                });
        }

        return view('site.users.team', compact('teamData'));
    }
}
