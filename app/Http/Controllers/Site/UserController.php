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
        $offices = Office::where('type', 'Regional')
            ->orWhere('name', 'Secretary C&W')
            ->get();
        
        $contactsByOffice = $offices->sortByDesc(function ($office) {
            $topUser = User::whereHas('currentPosting', function ($query) use ($office) {
                $query->where('office_id', $office->id);
            })
            ->whereHas('currentPosting.designation', function ($query) {
                $query->orderByDesc('bps');
            })
            ->featuredOnContact()
            ->with(['currentPosting.designation', 'profile'])
            ->first();

            return $topUser && $topUser->currentPosting && $topUser->currentPosting->designation ? 
                (is_numeric($topUser->currentPosting->designation->bps) ? $topUser->currentPosting->designation->bps : 0) : 0;
        })->mapWithKeys(function ($office) {
            $query = User::whereHas('profile', function ($q) {
                $q->where('featured_on', 'LIKE', '%"Contact"%');
            })
            ->with(['profile', 'currentPosting.designation', 'currentPosting.office']);
            
            if ($office->name === 'Secretary C&W') {
                $query->whereHas('currentPosting.office', function ($q) {
                    $q->where('type', 'Secretariat');
                });
            } else {
                $officeIds = [$office->id];
                
                $descendantOffices = $office->getAllDescendants();
                if ($descendantOffices->isNotEmpty()) {
                    $officeIds = array_merge($officeIds, $descendantOffices->pluck('id')->toArray());
                }
                
                $query->whereHas('currentPosting', function ($q) use ($officeIds) {
                    $q->whereIn('office_id', $officeIds);
                });
            }
            
            $contactsWithBps = $query->get()->map(function($user) {
                $bpsValue = 0;
                if ($user->currentPosting && $user->currentPosting->designation) {
                    $bpsRaw = $user->currentPosting->designation->bps;
                    if (preg_match('/(\d+)/', $bpsRaw, $matches)) {
                        $bpsValue = (int)$matches[1];
                    }
                }
                
                return [
                    'user' => $user,
                    'bps_value' => $bpsValue
                ];
            });
            
            $sortedContacts = $contactsWithBps->sortByDesc('bps_value');
            
            $contacts = $sortedContacts->map(function ($item) {
                $user = $item['user'];
                return (object) [
                    'name' => $user->name,
                    'office' => $user->currentPosting->office->name ?? 'N/A',
                    'designation' => $user->currentPosting->designation->name ?? 'N/A',
                    'bps' => $user->currentPosting->designation->bps ?? null,
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

        $currentPosting = $user->currentPosting;

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
            'position' => $currentPosting ? $currentPosting->designation->name ?? '-' : '-', 
            'title' => $currentPosting ? $currentPosting->designation->name ?? '-' : '-', 
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
                    $q->where('featured_on', 'LIKE', '%"Team"%');
                })
                ->with(['profile', 'currentPosting.designation', 'currentPosting.office', 'media']);

            if (isset($criteria['custom_query']) && $criteria['custom_query']) {
                $query = $criteria['callback']($query);
            } else {
                $query->whereHas('currentDesignation', function ($q) use ($criteria) {
                    $q->where('name', 'LIKE', $criteria['designation'] . '%');
                });
            }

            $teamData[$role] = $query->latest('created_at')
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'uuid' => $user->uuid,
                        'name' => $user->name,
                        'designation' => $user->currentPosting->designation->name ?? '-',
                        'office' => $user->currentPosting->office->name ?? '-',
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
