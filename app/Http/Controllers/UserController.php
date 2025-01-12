<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

use Spatie\Permission\Models\Role;
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
                    return view('admin.users.partials.buttons', compact('row'))->render();
                })
                ->editColumn('name', function ($row) {
                    return '<div style="display: flex; align-items: center;"><img style="width: 30px; height: 30px; border-radius: 50%;" src="' . getProfilePic($row) . '" /> <span> &nbsp; ' . $row->name . '</span></div>';
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
                ->rawColumns(['action', 'name']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.users.index');
    }

    public function users(Request $request)
    {
        $search = $request->get('q');
        $users = User::where('position', 'LIKE', "%{$search}%")
            ->select('id', 'position')
            ->paginate(10);

        return response()->json([
            'items' => $users->items(),
            'pagination' => [
                'more' => $users->hasMorePages()
            ]
        ]);
    }

    public function create()
    {
        $bps = [];
        for ($i = 1; $i <= 22; $i++) {
            $bps[] = sprintf("BPS-%02d", $i);
        }

        $cat = [
            'designations' => Category::where('type', 'designation')->get(),
            'positions' => Category::where('type', 'position')->get(),
            'offices' => Category::where('type', 'office')->get(),
            'bps' => $bps,
        ];
        return view('admin.users.create', compact('cat'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username ?? $this->generateUsername($request->email);
        $user->password = bcrypt($request->password);

        $user->designation = $request->designation;
        $user->position = $request->position;
        $user->office = $request->office;
        $user->title = $request->title ?? null;
        $user->bps = $request->bps ?? null;

        $user->mobile_number = $request->mobile_number ?? null;
        $user->landline_number = $request->landline_number ?? null;
        $user->cnic = $request->cnic ?? null;
        $user->posting_type = $request->posting_type ?? null;
        $user->posting_date = $request->posting_date ?? null;
        $user->exit_type = $request->exit_type ?? null;
        $user->exit_date = $request->exit_date ?? null;
        $user->message = $request->message ?? null;
        $user->facebook = $request->facebook ?? null;
        $user->whatsapp = $request->whatsapp ?? null;
        $user->twitter = $request->twitter ?? null;
        $user->uuid = Str::uuid();

        if ($request->hasFile('image')) {
            $user->addMedia($request->file('image'))
                ->toMediaCollection('profile_pictures');
        }

        if ($request->hasFile('posting_order')) {
            $user->addMedia($request->file('posting_order'))
                ->toMediaCollection('posting_orders');
        }

        if ($request->hasFile('exit_order')) {
            $user->addMedia($request->file('exit_order'))
                ->toMediaCollection('exit_orders');
        }

        if ($user->save()) {
            Cache::forget('message_partial');
            Cache::forget('team_partial');
            return redirect()->route('admin.users.create')->with('success', 'User added successfully');
        }

        return redirect()->route('admin.users.create')->with('danger', 'Error submitting the user');
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function activateUser(Request $request, User $user)
    {
        if ($user->status ===  'Inactive') {
            $user->status = 'Active';
            $message = 'User has been Activated successfully.';
        } else {
            $user->status = 'Inactive';
            $message = 'User has been Deactivate.';
        }
        Cache::forget('message_partial');
        Cache::forget('team_partial');
        $user->save();
        return response()->json(['success' => $message], 200);
    }

    public function archiveUser(Request $request, User $user)
    {
        $user->status = "Archived";
        if($user->save()) {
            Cache::forget('message_partial');
            Cache::forget('team_partial');
            return response()->json(['success' => 'User has been Archived'], 200);
        }
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
                    'result' => 'The user does not exists in Database',
                ],
            ]);
        }

        $data = [
            'user' => $user,
            'roles' => $user->roles,
            'permissions' => $user->getDirectPermissions(),
            'allRoles' => Role::all(),
            'allPermissions' => Permission::all(),
            'allDesignations' => Category::where('type', 'designation')->get(),
            'allPositions' => Category::where('type', 'position')->get(),
            'allOffices' => Category::where('type', 'office')->get(),
            'bps' => $bps,
        ];

        $html = view('admin.users.partials.edit', compact('data'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        
        $validated['featured_on'] = $request->has('featured_on') 
        ? json_encode($request->input('featured_on')) 
        : json_encode([]); 

        $user->fill(array_filter($validated, function ($value) {
            return $value !== null;
        }));

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('image')) {
            $user->addMedia($request->file('image'))
                ->toMediaCollection('profile_pictures');
        }

        if ($request->hasFile('posting_order')) {
            $user->addMedia($request->file('posting_order'))
                ->toMediaCollection('posting_orders');
        }

        if ($request->hasFile('exit_order')) {
            $user->addMedia($request->file('exit_order'))
                ->toMediaCollection('exit_orders');
        }

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        }

        if ($user->save()) {
            Cache::forget('message_partial');
            Cache::forget('team_partial');
            return response()->json(['success' => 'User updated']);
        }

        return response()->json(['error' => 'User updation failed']);
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

    public function assignBoss(Request $request)
    {
        $user = User::find($request->input('user_id'));
        $boss = User::find($request->input('boss_id'));

        $user->boss()->sync([$boss->id]);

        return redirect()->back()->with('success', 'Boss assigned successfully.');

        // $boss = $user->boss->first();
        // $subordinates = $user->subordinates;
    }
}
