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
        $offices = Office::whereIn('name', [
            'Secretary C&W', 'Chief Engineer North', 'Chief Engineer Mega Projects', 
            'Chief Engineer East', 'Chief Engineer Centre', 'Chief Engineer South-I', 'Chief Engineer South-II', 
            'Chief Engineer Maintenance', 'Chief Engineer CDO', 'Chief Engineer Foregn Aids', 'Managing Director PKHA'
        ])
        ->with(['currentPostings.user', 'currentPostings.designation', 'currentPostings.user.profile'])
        ->get();
        
        $contactsByOffice = $offices->sortByDesc(function ($office) {
            $topUser = $office->currentPostings()
                ->with('designation')
                ->whereHas('user', function($query) {
                    $query->featuredOnContact();
                })
                ->whereHas('designation')
                ->get()
                ->sortByDesc(function($posting) {
                    $bps = $posting->designation->bps ?? null;
                    return is_numeric($bps) ? (int) $bps : 0;
                })
                ->first();
                
            return $topUser && $topUser->designation ? 
                (is_numeric($topUser->designation->bps) ? $topUser->designation->bps : 0) : 0;
        })->mapWithKeys(function ($office) {
            $officeIds = [$office->id];
            
            // Include descendant offices if not Secretary C&W
            if ($office->name !== 'Secretary C&W') {
                $descendantOffices = $office->getAllDescendants();
                if ($descendantOffices->isNotEmpty()) {
                    $officeIds = array_merge($officeIds, $descendantOffices->pluck('id')->toArray());
                }
            } elseif ($office->name === 'Secretary C&W') {
                // For Secretary C&W, use Secretariat type offices
                $secretariatOffices = Office::where('type', 'Secretariat')->pluck('id')->toArray();
                $officeIds = $secretariatOffices;
            }
            
            $relevantOffices = Office::whereIn('id', $officeIds)
                ->with(['currentPostings.user' => function($query) {
                    $query->whereHas('profile', function($q) {
                        $q->where('featured_on', 'LIKE', '%"Contact"%');
                    })->with('profile');
                }, 'currentPostings.designation'])
                ->get();
                
            $contactsData = collect();
            
            foreach ($relevantOffices as $relOffice) {
                $featuredUsers = $relOffice->currentPostings
                    ->filter(function($posting) {
                        return $posting->user && $posting->user->profile && 
                            strpos($posting->user->profile->featured_on ?? '', '"Contact"') !== false;
                    })
                    ->map(function($posting) use ($relOffice) {
                        $user = $posting->user;
                        $bpsValue = 0;
                        
                        if ($posting->designation && is_numeric($posting->designation->bps)) {
                            $bpsValue = (int) $posting->designation->bps;
                        }
                        
                        return [
                            'user' => $user,
                            'office' => $relOffice,
                            'designation' => $posting->designation,
                            'bps_value' => $bpsValue
                        ];
                    });
                    
                $contactsData = $contactsData->merge($featuredUsers);
            }
            
            $sortedContacts = $contactsData->sortByDesc('bps_value');
            
            $contacts = $sortedContacts->map(function ($item) {
                $user = $item['user'];
                $office = $item['office'];
                
                return (object) [
                    'office' => $office->name ?? 'N/A',
                    'bps' => $item['designation']->bps ?? null,
                    'mobile_number' => $user->profile ? $user->profile->mobile_number : null,
                    'contact_number' => $office->contact_number ?? null,
                    'facebook' => $user->facebook ?? null,
                    'twitter' => $user->twitter ?? null,
                    'email' => $user->email ?? null,
                    'whatsapp' => $user->profile ? $user->profile->whatsapp : null,
                ];
            });

            return [$office->name => $contacts];
        });

        return view('site.users.contacts', compact('contactsByOffice'));
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
            'name' => $user->name ?? 'N/A',
            'uuid' => $user->uuid ?? '-',
            'email' => $user->email ?? 'N/A',
            'mobile_number' => $profile->mobile_number ?? 'N/A',
            'contact_number' => $currentPosting?->office?->contact_number ?? 'N/A',
            'whatsapp' => $profile->whatsapp ?? 'N/A',
            'facebook' => $profile->facebook ?? 'N/A',
            'twitter' => $profile->twitter ?? 'N/A',
            'designation' => $currentPosting?->designation?->name ?? 'N/A',
            'office' => $currentPosting?->office?->name ?? 'N/A', 
            'posting_type' => $currentPosting?->type ?? 'N/A',
            'posting_date' => $currentPosting?->start_date?->format('j, F Y') ?? 'N/A',
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
            'history' => $user->postings()->orderBy('end_date')->get() ?? [],
            'previous' => $currentPosting->office->formerPostings($currentPosting->designation->id)->get() ?? [],
            'views_count' => $profile->views_count ?? 0,
            'job_description' => $user->currentOffice?->job_description,
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
                            $q->where('bps', '17')
                                ->orWhere('bps', '18');
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
                        'contact_number' => $user->profile ? $user->profile->contact_number ?? '#' : '#',
                        'image' => $user->getFirstMediaUrl('profile_pictures', 'small')
                            ?: asset('admin/images/default-avatar.jpg'),
                    ];
                });
        }

        return view('site.users.team', compact('teamData'));
    }
}
