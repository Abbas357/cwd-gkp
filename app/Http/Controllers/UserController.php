<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

use App\Models\Categories\Office;
use Spatie\Permission\Models\Role;
use App\Models\Categories\Designation;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $active = $request->query('active', null);

        $users = User::query();

        $users->when($active !== null, function ($query) use ($active) {
            $query->where('is_active', $active);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('users.partials.buttons', compact('row'))->render();
                })
                ->editColumn('is_active', function ($row) {
                    return $row->is_active == 1 ? 'Yes' : 'No';
                })
                ->editColumn('password_updated_at', function ($row) {
                    return $row->password_updated_at ? $row->password_updated_at->diffForHumans() : 'Not Updated Yet';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->diffForHumans();
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

        return view('users.index');
    }

    public function users(Request $request)
    {
        $search = $request->get('q');
        $users = User::where('name', 'LIKE', "%{$search}%")
            ->select('id', 'name')
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
            'designations' => Designation::all(),
            'offices' => Office::all(),
            'roles' => Role::all(),
            'permissions' => Permission::all()
        ];
        return view('users.create', compact('cat'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->mobile_number = $request->mobile_number;
        $user->landline_number = $request->landline_number;
        $user->cnic = $request->cnic;
        $user->designation = $request->designation;
        $user->office = $request->office;

        if ($request->has('image')) {
            // Store Image
        }

        if ($request->has('role')) {
            // Store Role
        }

        if ($user->save()) {
            return redirect()->route('users.create')->with('success', 'User added successfully');
        }

        return redirect()->route('users.create')->with('danger', 'Error submitting the user');
    }

    public function show(User $user)
    {
        if ($user) {
            $userRoles = $user->roles; 
            $userPermissions = $user->getDirectPermissions();
            $allRoles = Role::all();
            $allPermissions = Permission::all();
            $allDesignations = Designation::all();
            $allOffices = Office::all();

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user,
                    'userRoles' => $userRoles,
                    'allRoles' => $allRoles,
                    'userPermissions' => $userPermissions,
                    'allPermissions' => $allPermissions,
                    'allDesignations' => $allDesignations,
                    'allOffices' => $allOffices,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => 'User not found.',
        ]);
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        if ($user->delete()) {
            return response()->json(['success' => 'User has been deleted successfully.']);
        }

        return response()->json(['error' => 'User can\'t be deleted.']);
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

    public function assignRole(Request $request, User $user)
    {
        $roles = $request->roles;

        $existingRoles = array_intersect($roles, $user->getRoleNames()->toArray());
        if (!empty($existingRoles)) {
            return back()->with('danger', 'Roles already assigned previously.');
        }

        $user->syncRoles($roles);
        return back()->with('success', 'Roles successfully assigned');
    }

    public function revokeRole(User $user, Role $role)
    {
        $user->removeRole($role);
        return redirect()->back()->with('success', 'Role removed successfully!');
    }

    public function clearRoles(User $user)
    {
        $user->roles()->detach();
        return redirect()->back()->with('success', 'All roles removed successfully!');
    }
}
