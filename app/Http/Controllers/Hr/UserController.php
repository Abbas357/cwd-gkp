<?php

namespace App\Http\Controllers\Hr;

use App\Models\User;
use App\Models\Office;
use App\Models\Posting;
use App\Models\District;
use App\Helpers\Database;
use App\Models\Designation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\SearchBuilder;
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

        $relationMappings = [
            'designation' => 'currentPosting.designation.name',
            'office' => 'currentPosting.office.name'
        ];

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

            if ($request->input('search.value')) {
                Database::applyRelationalSearch($dataTable, $relationMappings);
            }

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request, $relationMappings) {
                    $sb = new SearchBuilder(
                        $request, 
                        $query,
                        [],
                        $relationMappings,
                    );
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('modules.hr.users.index');
    }

    public function users(Request $request)
    {
        return $this->getApiResults(
            $request, 
            User::class, 
            [
                'searchColumns' => ['name', 'email', 'username'],
                'withRelations' => ['currentPosting.designation', 'currentPosting.office'],
                'textFormat' => function($user) {
                    return $user->name . ' - ' . 
                        ($user->currentPosting ? 
                            $user->currentPosting->designation->name . ' at ' . 
                            $user->currentPosting->office->name 
                        : 'No Current Posting');
                },
                'searchRelations' => [
                    'currentPosting.designation' => ['name'],
                    'currentPosting.office' => ['name']
                ],
                'orderBy' => 'id',
            ]
        );
    }

    public function create()
    {
        $data = [
            'designations' => Designation::where('status', 'Active')->get(),
            'offices' => Office::where('status', 'Active')->get(),
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
            $userData = $request->only(['name', 'email', 'password']);
            $userData['uuid'] = Str::uuid();
            $userData['username'] = $request->username ?? strstr($request->email, '@', true);

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            } else {
                $userData['password'] = Hash::make($userData['username']);
            }
            $userData['password_updated_at'] = now();

            $user = User::create($userData);
            $profileData = $request->input('profile', []);

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );

            if ($request->has('posting')) {
                $postingData = $request->input('posting');
                $postingData['type'] = 'Appointment';
                
                if (isset($postingData['office_id']) && isset($postingData['designation_id'])) {
                     $this->handleRegularPosting($user, $postingData, $request);
                }
            }

            if ($request->hasFile('image')) {
                $user->addMedia($request->file('image'))
                    ->toMediaCollection('profile_pictures');
            }

            DB::commit();
            Cache::forget('message_partial');
            Cache::forget('team_partial');

            return response()->json(['success' => 'User created successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create user: ' . $e->getMessage()]);
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
            'allDesignations' => Designation::where('status', 'Active')->get(),
            'allOffices' => Office::where('status', 'Active')->get(),
            'bps' => $bps,
            'posting_types' => category('posting_type', 'hr')
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
            $userData = $request->only(['name', 'username', 'email', 'status']);
            
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
                $userData['password_updated_at'] = now();
            }

            $user->update($userData);
            
            $profileData = $request->input('profile', []);
            if (isset($profileData['featured_on'])) {
                $profileData['featured_on'] = json_encode($profileData['featured_on']);
            }
            
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );

            if ($request->has('posting')) {
                $postingData = $request->input('posting');
                $postingType = $postingData['type'] ?? null;


                if ($postingType && isset($postingData['office_id']) && isset($postingData['designation_id'])) {
                    $currentPosting = $user->currentPosting;
                    $postingChanged = $this->hasPostingChanged($currentPosting, $postingData);
                    
                    if($postingChanged) {
                        switch ($postingType) {
                            case 'Mutual':
                                $this->handleMutualTransfer($user, $postingData, $request);
                                break;
                                
                            case 'Suspension':
                            case 'OSD':
                                $this->handleSpecialStatus($user, $postingType, $postingData);
                                break;
    
                            case 'Additional-Charge':
                                $this->handleAdditionalCharge($user, $postingData, $request);
                                break;
    
                            case 'Retirement':
                            case 'Termination':
                            case 'Out-Transfer':
                                $this->handleExitStatus($user, $postingType, $postingData);
                                break;
                            
                            default: // Appointment, Transfer, Promotion
                                $this->handleRegularPosting($user, $postingData, $request);
                                break;
                        }
                    }
                }
            }

            if ($request->hasFile('image')) {
                $user->addMedia($request->file('image'))
                    ->toMediaCollection('profile_pictures');
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

    private function hasPostingChanged($currentPosting, array $newPostingData)
    {
        // If there's no current posting but we're creating one, that's a change
        if (!$currentPosting) {
            return true;
        }
        
        // Check if office, designation or type has changed
        if ($currentPosting->office_id != $newPostingData['office_id'] ||
            $currentPosting->designation_id != $newPostingData['designation_id'] ||
            $currentPosting->type != $newPostingData['type']) {
            return true;
        }
        
        // If the order number is being changed, consider it a posting change
        if (isset($newPostingData['order_number']) && 
            $currentPosting->order_number != $newPostingData['order_number']) {
            return true;
        }
        
        // No significant changes detected
        return false;
    }


    private function handleAdditionalCharge(User $user, array $postingData, Request $request)
    {
        // For Additional-Charge, we create a new posting but maintain the existing one as active
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
    }

    private function handleMutualTransfer(User $user, array $postingData, Request $request)
    {
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

    private function handleExitStatus(User $user, string $statusType, array $postingData)
    {
        DB::transaction(function () use ($user, $postingData, $statusType) {
            // End current posting if exists
            if ($currentPosting = $user->currentPosting) {
                $currentPosting->update([
                    'is_current' => false,
                    'end_date' => now()
                ]);
            }
        
            // Create new posting with special status
            $posted = $user->postings()->create([
                'office_id' => null,
                'designation_id' => $postingData['designation_id'],
                'type' => $statusType,
                'start_date' => $postingData['start_date'] ?? now(),
                'remarks' => $postingData['remarks'] ?? $statusType . ' status applied',
                'order_number' => $postingData['order_number'] ?? null,
                'is_current' => true
            ]);
        
            if ($posted) {
                $user->status = 'Archived';
                $user->save();
            }
        });
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

    public function employee($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $bps = [];
        for ($i = 1; $i <= 22; $i++) {
            $bps[] = sprintf("BPS-%02d", $i);
        }

        $posting_types = ['Appointment', 'Deputation', 'Transfer', 'Mutual', 'Additional-Charge', 'Promotion', 'Suspension', 'OSD', 'Out-Transfer', 'Retirement', 'Termination'];
        if (!$user) {
            return redirect()->route('admin.apps.hr.users.index')->with('error', 'The user does not exist in Database');
        }

        $data = [
            'user' => $user->load(['profile', 'currentPosting.designation', 'currentPosting.office', 'postings.designation', 'postings.office']),
            'roles' => $user->roles,
            'permissions' => $user->getDirectPermissions(),
            'allRoles' => Role::all(),
            'allPermissions' => Permission::all(),
            'allDesignations' => Designation::where('status', 'Active')->get(),
            'allOffices' => Office::where('status', 'Active')->get(),
            'bps' => $bps,
            'posting_types' => $posting_types
        ];

        return view('modules.hr.users.profile.index', compact('data'));
    }

    public function userQuickCreate()
    {
        $data = [
            'roles' => Role::all(),
            'permissions' => Permission::all()->take(10),
            'designations' => Designation::where('status', 'Active')->get(),
            'offices' => Office::where('status', 'Active')->get(),
            'districts' => District::all(),
        ];

        $html = view('modules.hr.users.partials.quick-create', compact('data'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function userQuickStore(Request $request)
    {
        DB::beginTransaction();

        try {
            $designationId = $request->input('posting.designation_id');
            if ($designationId === 'new' && $request->filled('new_designation')) {
                $designation = Designation::create([
                    'name' => $request->input('new_designation'),
                    'bps' => $request->input('new_designation_bps'),
                    'status' => 'Active'
                ]);
                $designationId = $designation->id;
            }

            $officeId = $request->input('posting.office_id');
            if ($officeId === 'new' && $request->filled('new_office')) {
                $office = Office::create([
                    'name' => $request->input('new_office'),
                    'type' => $request->input('new_office_type'),
                    'contact_number' => $request->input('new_office_contact_number'),
                    'parent_id' => $request->input('new_office_parent_id') ?: null,
                    'district_id' => $request->input('new_district_id') ?: null,
                    'status' => 'Active'
                ]);
                $officeId = $office->id;
            }

            $userData['name'] = $request->name;
            $userData['email'] = strtolower(preg_replace('/\s+/', '', $request->name)) . rand(10000, 99999) . '@cwd.gkp.pk'; 
            $userData['uuid'] = Str::uuid();
            $userData['username'] = $request->username ?? $this->generateUsername($request->email);
            $userData['password'] = Hash::make(Str::random(8));
            $userData['password_updated_at'] = now();
            $userData['status'] = 'Active';
            
            $user = User::create($userData);

            $profileData = $request->input('profile', []);
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );

            if ($designationId && $officeId) {
                $postingData = [
                    'office_id' => $officeId,
                    'designation_id' => $designationId,
                    'type' => 'Appointment',
                    'start_date' => now(),
                    'is_current' => true
                ];
                
                $sanctionedPost = SanctionedPost::firstOrCreate(
                    [
                        'office_id' => $officeId,
                        'designation_id' => $designationId,
                    ],
                    [
                        'total_positions' => 1,
                        'status' => 'Active'
                    ]
                );
                
                $user->postings()->create($postingData);
            }

            DB::commit();
            Cache::forget('message_partial');
            Cache::forget('team_partial');

            $response = [
                'success' => 'User created successfully',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'designation' => $designationId ? Designation::find($designationId)->name : null,
                    'office' => $officeId ? Office::find($officeId)->name : null,
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create user: ' . $e->getMessage()], 422);
        }
    }

}
