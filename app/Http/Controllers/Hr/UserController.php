<?php

namespace App\Http\Controllers\Hr;

use App\Models\User;
use App\Models\Office;

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
            $userData = $request->only([
                'name',
                'username',
                'email',
                'status'
            ]);

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

                $hasPostingData = !empty($postingData['designation_id']) &&
                    !empty($postingData['office_id']) &&
                    !empty($postingData['type']);

                if ($hasPostingData) {
                    $currentPosting = $user->currentPosting;

                    $hasPostingChanges = !$currentPosting ||
                        $currentPosting->designation_id != $postingData['designation_id'] ||
                        $currentPosting->office_id != $postingData['office_id'] ||
                        $currentPosting->type != $postingData['type'];

                    if ($hasPostingChanges) {
                        // Validate against sanctioned posts
                        $sanctionedPost = \App\Models\SanctionedPost::where('office_id', $postingData['office_id'])
                            ->where('designation_id', $postingData['designation_id'])
                            ->where('status', 'Active')
                            ->first();

                        if (!$sanctionedPost) {
                            return response()->json([
                                'error' => 'This position is not sanctioned for the selected office.'
                            ], 422);
                        }

                        // Check if there's vacancy (unless it's the same user in the same position)
                        $isSamePosition = $currentPosting &&
                            $currentPosting->office_id == $postingData['office_id'] &&
                            $currentPosting->designation_id == $postingData['designation_id'];

                        if (!$isSamePosition && $sanctionedPost->vacancies <= 0) {
                            return response()->json([
                                'error' => 'No vacancy available for this position in the selected office.'
                            ], 422);
                        }

                        // End the current posting
                        if ($currentPosting) {
                            $currentPosting->update([
                                'is_current' => false,
                                'end_date' => now()
                            ]);
                        }

                        // Create new posting
                        $user->postings()->create([
                            'designation_id' => $postingData['designation_id'],
                            'office_id' => $postingData['office_id'],
                            'type' => $postingData['type'],
                            'start_date' => $postingData['start_date'] ?? now(),
                            'remarks' => $postingData['remarks'] ?? null,
                            'is_current' => true,
                            'order_number' => $postingData['order_number'] ?? null
                        ]);
                    } else if ($currentPosting) {
                        // Update existing posting details
                        $updateData = [];

                        if (isset($postingData['start_date'])) {
                            $updateData['start_date'] = $postingData['start_date'];
                        }

                        if (isset($postingData['remarks'])) {
                            $updateData['remarks'] = $postingData['remarks'];
                        }

                        if (isset($postingData['order_number'])) {
                            $updateData['order_number'] = $postingData['order_number'];
                        }

                        if (!empty($updateData)) {
                            $currentPosting->update($updateData);
                        }
                    }
                }
            }

            if ($request->hasFile('image')) {
                $user->addMedia($request->file('image'))
                    ->toMediaCollection('profile_pictures');
            }

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
