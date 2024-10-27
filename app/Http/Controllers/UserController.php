<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $active = $request->query('active', null);

        $users = User::query()->latest('id')->withoutGlobalScope('active');

        $users->when($active !== null, function ($query) use ($active) {
            $query->where('is_active', $active);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.users.partials.buttons', compact('row'))->render();
                })
                ->editColumn('is_active', function ($row) {
                    return $row->is_active == 1 ? 'Yes' : 'No';
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
                ->rawColumns(['action']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\SearchBuilder($request, $query);
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
        $users = User::where('designation', 'LIKE', "%{$search}%")
            ->select('id', 'designation')
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
        $cat = [
            'designations' => Category::where('type', 'designation')->get(),
            'offices' => Category::where('type', 'office')->get(),
            'bps' => Category::where('type', 'bps')->get(),
            'roles' => Role::all(),
            'permissions' => Permission::all()
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
            return redirect()->route('admin.users.create')->with('success', 'User added successfully');
        }

        return redirect()->route('admin.users.create')->with('danger', 'Error submitting the user');
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function activateUser(Request $request, $userId)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($userId);
        if ($user->is_active ===  0) {
            $user->is_active = 1;    
            $message = 'User has been Activated successfully.';
        } else {
            $user->is_active = 0;
            $message = 'User has been Deactivate.';
        }
        $user->save();
        return response()->json(['success' => $message], 200);
    }

    public function edit(User $user)
    {
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
            'allOffices' => Category::where('type', 'office')->get(),
            'bps' => Category::where('type', 'bps')->get(),
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
            return response()->json(['success' => 'User updated']);
        }
        return response()->json(['error' => 'User updation failed']);
    }

    public function destroy(User $user)
    {
        if ($user->delete()) {
            return response()->json(['success' => 'User has been deleted successfully.']);
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
