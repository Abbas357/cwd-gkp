<?php

namespace App\Http\Controllers\Hr;

use App\Models\User;
use App\Models\Office;

use App\Models\Posting;
use App\Models\District;

use App\Models\Designation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SanctionedPost;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $active = $request->query('status', null);

        $users = User::query()->withoutGlobalScope('active');

        $users->when($active !== null, function ($query) use ($active) {
            $query->where('status', $active);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.hr.users.partials.buttons', compact('row'))->render();
                })
                ->editColumn('name', function ($row) {
                    return '<div style="display: flex; align-items: center;"><img style="width: 30px; height: 30px; border-radius: 50%;" src="' . getProfilePic($row) . '" /> <span> &nbsp; ' . $row->name . '</span></div>';
                })
                ->addColumn('current_posting', function ($row) {
                    return view('modules.hr.users.partials.user-posting-badge', ['user' => $row])->render();
                })
                ->editColumn('password_updated_at', function ($row) {
                    return $row->password_updated_at ? $row->password_updated_at->diffForHumans() : 'Not Updated Yet';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'current_posting', 'name']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('modules.hr.users.index');
    }

    public function users(Request $request)
    {
        $users = User::query()
            ->when($request->q, fn($q) => $q->where('name', 'like', "%{$request->q}%")
                ->orWhereHas('currentPosting.designation', function($query) use ($request) {
                    $query->where('name', 'like', "%{$request->q}%");
                })
                ->orWhereHas('currentPosting.office', function($query) use ($request) {
                    $query->where('name', 'like', "%{$request->q}%");
                }))
            ->with(['currentPosting.designation', 'currentPosting.office'])
            ->paginate(10);

        return response()->json([
            'results' => collect($users->items())->map(fn($u) => [
                'id' => $u->id,
                'text' => $u->name . ' - ' . 
                    ($u->currentPosting ? 
                        $u->currentPosting->designation->name . ' at ' . 
                        $u->currentPosting->office->name 
                    : 'No Current Posting')
            ]),
            'pagination' => [
                'more' => $users->hasMorePages()
            ]
        ]);
    }

    public function create()
    {
        $offices = Office::where('status', 'Active')->get();
        $designations = Designation::where('status', 'Active')->get();
        $postingTypes = [
            'Appointment' => 'Appointment',
            'Transfer' => 'Transfer',
            'Promotion' => 'Promotion'
        ];
        $data = [
            'offices' => $offices,
            'designations' => $designations,
            'postingTypes' => $postingTypes,
        ];
        
        $html = view('modules.hr.users.partials.create', compact('data'))->render();
        
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();
        
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username ?? $this->generateUsername($request->email);
            $user->password = bcrypt($request->password);
            $user->uuid = Str::uuid();

            if ($request->hasFile('image')) {
                $user->addMedia($request->file('image'))
                    ->toMediaCollection('profile_pictures');
            }

            $user->save();
            
            $profileData = $request->input('profile', []);
            $user->profile()->create($profileData);
            
            $postingData = $request->input('posting');
            if (!empty($postingData['designation_id']) && !empty($postingData['office_id']) && !empty($postingData['type'])) {
                $sanctionedPost = SanctionedPost::where('office_id', $postingData['office_id'])
                    ->where('designation_id', $postingData['designation_id'])
                    ->where('status', 'Active')
                    ->first();
                    
                if (!$sanctionedPost) {
                    return response()->json([
                        'error' => 'This position is not sanctioned for the selected office.'
                    ], 422);
                }
                
                if ($sanctionedPost->vacancies <= 0) {
                    return response()->json([
                        'error' => 'No vacancy available for this position in the selected office.'
                    ], 422);
                }
                
                $posting = $user->postings()->create([
                    'designation_id' => $postingData['designation_id'],
                    'office_id' => $postingData['office_id'],
                    'type' => $postingData['type'],
                    'start_date' => $postingData['start_date'] ?? now(),
                    'is_current' => true
                ]);
                
                if ($request->hasFile('posting_order')) {
                    $posting->addMedia($request->file('posting_order'))
                        ->toMediaCollection('posting_orders');
                }
            }
            
            DB::commit();

            Cache::forget('message_partial');
            Cache::forget('team_partial');
            
            return response()->json(['success' => 'User added successfully']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error creating user: ' . $e->getMessage()]);
        }
    }
    
    public function show(User $user)
    {
        return response()->json($user);
    }

    public function edit(User $user)
    {
        $bps = [];
        for ($i = 1; $i <= 22; $i++) {
            $bps[] = sprintf("BPS-%02d", $i);
        }

        $posting_types = ['Appointment', 'Deputation', 'Transfer', 'Mutual', 'Additional-Charge', 'Promotion', 'Suspension', 'OSD', 'Retirement', 'Termination'];
        if (!$user) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'The user does not exist in Database',
                ],
            ]);
        }

        $data = [
            'user' => $user->load(['profile', 'currentPosting.designation', 'currentPosting.office']),
            'roles' => $user->roles,
            'permissions' => $user->getDirectPermissions(),
            'allRoles' => Role::all(),
            'allPermissions' => Permission::all(),
            'allDesignations' => Designation::where('status', 'Active')->get(),
            'allOffices' => Office::where('status', 'Active')->get(),
            'bps' => $bps,
            'posting_types' => $posting_types
        ];

        $html = view('modules.hr.users.partials.edit', compact('data'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        DB::beginTransaction();

        try {
            // Update basic user information
            $userData = $request->only(['name', 'username', 'email', 'status']);
            
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
                $userData['password_updated_at'] = now();
            }

            $user->update($userData);
            
            // Update profile data
            $profileData = $request->input('profile', []);
            if (isset($profileData['featured_on'])) {
                $profileData['featured_on'] = json_encode($profileData['featured_on']);
            }
            
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );

            // Handle posting changes
            if ($request->has('posting')) {
                $postingData = $request->input('posting');
                $postingType = $postingData['type'] ?? null;
                
                if ($postingType && isset($postingData['office_id']) && isset($postingData['designation_id'])) {
                    $currentPosting = $user->currentPosting;
                    
                    // Handle based on posting type
                    switch ($postingType) {
                        case 'Mutual':
                            $this->handleMutualTransfer($user, $postingData, $request);
                            break;
                            
                        case 'Retirement':
                        case 'Suspension':
                        case 'OSD':
                            $this->handleSpecialStatus($user, $postingType, $postingData);
                            break;
                            
                        case 'Additional-Charge':
                            $this->handleAdditionalCharge($user, $postingData, $request);
                            break;
                            
                        default: // Appointment, Transfer, Promotion
                            $this->handleRegularPosting($user, $postingData, $request);
                            break;
                    }
                }
            }

            // Handle file uploads
            if ($request->hasFile('image')) {
                $user->addMedia($request->file('image'))
                    ->toMediaCollection('profile_pictures');
            }

            // Handle roles and permissions
            if ($request->has('roles')) {
                $user->syncRoles($request->roles);
            }

            if ($request->has('permissions')) {
                $user->syncPermissions($request->permissions);
            }

            DB::commit();
            Cache::forget('message_partial');
            Cache::forget('team_partial');

            return response()->json(['success' => 'User updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update user: ' . $e->getMessage()]);
        }
    }

    private function handleAdditionalCharge(User $user, array $postingData, Request $request)
    {
        // For Additional-Charge, we create a new posting but maintain the existing one as active

        // Check if exceeding sanctioned strength
        if (!$request->has('override_sanctioned_post')) {
            $sanctionedPost = SanctionedPost::where('office_id', $postingData['office_id'])
                ->where('designation_id', $postingData['designation_id'])
                ->where('status', 'Active')
                ->first();
                
            if (!$sanctionedPost) {
                throw new \Exception('This position is not sanctioned for the selected office.');
            }
        }
        
        // Create new posting for the additional charge WITHOUT ending current posting
        $newPosting = $user->postings()->create([
            'office_id' => $postingData['office_id'],
            'designation_id' => $postingData['designation_id'],
            'type' => 'Additional-Charge',
            'start_date' => $postingData['start_date'] ?? now(),
            'remarks' => $postingData['remarks'] ?? 'Additional charge posting',
            'order_number' => $postingData['order_number'] ?? null,
            'is_current' => true  // This is also marked as current alongside the main posting
        ]);
        
        // If posting order file is provided
        if ($request->hasFile('posting_order')) {
            $newPosting->addMedia($request->file('posting_order'))
                ->toMediaCollection('posting_orders');
        }
        
        // Check if vacating another officer from the additional charge position
        if ($request->has('vacate_officer_id')) {
            $officerToVacate = User::findOrFail($request->input('vacate_officer_id'));
            
            // Find the posting at the specific office/designation
            $vacatePosting = $officerToVacate->postings()
                ->where('office_id', $postingData['office_id'])
                ->where('designation_id', $postingData['designation_id'])
                ->where('is_current', true)
                ->first();
                
            if ($vacatePosting) {
                $vacatePosting->update([
                    'is_current' => false,
                    'end_date' => now()
                ]);
            }
        }
        
        // Log additional charge
        activity()
            ->performedOn($newPosting)
            ->causedBy($request->user())
            ->withProperties([
                'type' => 'Additional-Charge',
                'maintains_current_posting' => true
            ])
            ->log('Created additional charge posting');
    }

    private function handleMutualTransfer(User $user, array $postingData, Request $request)
    {
        // Get current posting of the user
        $currentPosting = $user->currentPosting;
        
        if (!$currentPosting) {
            throw new \Exception('Cannot perform mutual transfer. The selected officer does not have an active posting.');
        }
        
        // Check if mutual transfer partner is specified
        $mutualPartnerId = $request->input('mutual_transfer_user_id');
        
        if (!$mutualPartnerId) {
            // Check if there's someone in the target position
            $partnerPosting = Posting::where('office_id', $postingData['office_id'])
                ->where('designation_id', $postingData['designation_id'])
                ->where('is_current', true)
                ->first();
                
            if (!$partnerPosting) {
                throw new \Exception('No officer found in the target position for mutual transfer.');
            }
            
            $mutualPartnerId = $partnerPosting->user_id;
        }
        
        $mutualPartner = User::findOrFail($mutualPartnerId);
        $partnerPosting = $mutualPartner->currentPosting;
        
        if (!$partnerPosting) {
            throw new \Exception('Mutual transfer partner does not have an active posting.');
        }
        
        // End current postings
        $currentPosting->update([
            'is_current' => false,
            'end_date' => now()
        ]);
        
        $partnerPosting->update([
            'is_current' => false,
            'end_date' => now()
        ]);
        
        // Create new postings (swapped)
        $user->postings()->create([
            'office_id' => $partnerPosting->office_id,
            'designation_id' => $partnerPosting->designation_id,
            'type' => 'Mutual',
            'start_date' => $postingData['start_date'] ?? now(),
            'remarks' => 'Mutual transfer with ' . $mutualPartner->name,
            'order_number' => $postingData['order_number'] ?? null,
            'is_current' => true
        ]);
        
        $mutualPartner->postings()->create([
            'office_id' => $currentPosting->office_id,
            'designation_id' => $currentPosting->designation_id,
            'type' => 'Mutual',
            'start_date' => $postingData['start_date'] ?? now(),
            'remarks' => 'Mutual transfer with ' . $user->name,
            'order_number' => $postingData['order_number'] ?? null,
            'is_current' => true
        ]);
    }

    private function handleSpecialStatus(User $user, string $statusType, array $postingData)
    {
        // End current posting if exists
        if ($currentPosting = $user->currentPosting) {
            $currentPosting->update([
                'is_current' => false,
                'end_date' => now()
            ]);
        }
        
        // Create new posting with special status
        $user->postings()->create([
            'office_id' => null, // No office for these status types
            'designation_id' => $postingData['designation_id'],
            'type' => $statusType,
            'start_date' => $postingData['start_date'] ?? now(),
            'remarks' => $postingData['remarks'] ?? $statusType . ' status applied',
            'order_number' => $postingData['order_number'] ?? null,
            'is_current' => true
        ]);
    }

    private function handleRegularPosting(User $user, array $postingData, Request $request)
    {
        // Check if vacating another officer
        if ($request->has('vacate_officer_id')) {
            $officerToVacate = User::findOrFail($request->input('vacate_officer_id'));
            $vacateReason = $request->input('vacate_reason', 'Transfer');
            
            if ($currentVacatePosting = $officerToVacate->currentPosting) {
                $currentVacatePosting->update([
                    'is_current' => false,
                    'end_date' => now()
                ]);
                
                // If vacating with special status, create appropriate posting
                if (in_array($vacateReason, ['Retirement', 'Suspension', 'OSD'])) {
                    $officerToVacate->postings()->create([
                        'office_id' => null,
                        'designation_id' => $currentVacatePosting->designation_id,
                        'type' => $vacateReason,
                        'start_date' => now(),
                        'remarks' => 'Vacated for new posting of ' . $user->name,
                        'is_current' => true
                    ]);
                }
            }
        }
        
        // Check if exceeding sanctioned strength
        if (!$request->has('override_sanctioned_post')) {
            $sanctionedPost = SanctionedPost::where('office_id', $postingData['office_id'])
                ->where('designation_id', $postingData['designation_id'])
                ->where('status', 'Active')
                ->first();
                
            if (!$sanctionedPost) {
                throw new \Exception('This position is not sanctioned for the selected office.');
            }
            
            if (!$sanctionedPost->isAvailableForPosting($postingData['type'], $user->id)) {
                if (!$request->has('excess_justification')) {
                    throw new \Exception('No vacancy available for this position in the selected office.');
                }
            }
        }
        
        // End current posting if exists
        if ($currentPosting = $user->currentPosting) {
            $currentPosting->update([
                'is_current' => false,
                'end_date' => now()
            ]);
        }
        
        // Create new posting
        $newPosting = $user->postings()->create([
            'office_id' => $postingData['office_id'],
            'designation_id' => $postingData['designation_id'],
            'type' => $postingData['type'],
            'start_date' => $postingData['start_date'] ?? now(),
            'remarks' => $postingData['remarks'] ?? null,
            'order_number' => $postingData['order_number'] ?? null,
            'is_current' => true
        ]);
        
        // If posting order file is provided
        if ($request->hasFile('posting_order')) {
            $newPosting->addMedia($request->file('posting_order'))
                ->toMediaCollection('posting_orders');
        }
        
        // Log if exceeding sanctioned strength
        if ($request->has('excess_justification')) {
            activity()
                ->performedOn($newPosting)
                ->causedBy($request->user())
                ->withProperties([
                    'justification' => $request->input('excess_justification'),
                    'exceeded_sanctioned_strength' => true
                ])
                ->log('Created posting exceeding sanctioned strength');
        }
    }

    private function generateUsername($email)
    {
        $username = strstr($email, '@', true);

        $originalUsername = $username;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . '-' . $counter;
            $counter++;
        }

        return $username;
    }

    public function getCurrentPosting(Request $request)
    {
        $userId = $request->input('user_id');
        $user = User::findOrFail($userId);
        
        $currentPosting = $user->currentPosting()->with(['office', 'designation'])->first();
        
        return response()->json([
            'current_posting' => $currentPosting
        ]);
    }

    public function destroy(User $user)
    {
        if (request()->user()->isAdmin()) {
            if ($user->delete()) {
                Cache::forget('message_partial');
                Cache::forget('team_partial');
                return response()->json(['success' => 'User has been deleted successfully.']);
            }
        }

        return response()->json(['error' => 'User can\'t be deleted.']);
    }
}
