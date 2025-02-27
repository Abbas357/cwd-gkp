<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

use App\Models\User;

use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::whereNotIn('name', ['admin'])->paginate(100);
        $users = User::with('roles')->paginate(10);
        return view('admin.roles.index', compact('roles', 'users'));
    }

    public function store(StoreRoleRequest $request)
    {
        Role::create(['name' => $request->name]);
        return to_route('admin.roles.index')->with('success', 'Role Created successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return back()->with('success', 'Role deleted.');
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => 'array|exists:permissions,name'
        ]);

        $role->syncPermissions($validated['permissions']);

        if($role->save()) {
            return response()->json(['success' => 'Permissions updated']);
        }
        return response()->json(['error' => 'Permissions cannot be updated']);
    }

    public function revokePermission(Role $role, Permission $permission)
    {
        $role->revokePermissionTo($permission);
        return redirect()->back()->with('success', 'Permission removed from role.');
    }

    public function getPermissions(Role $role)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'role' => $role->name,
                'permissions' => $role->permissions,
                'allPermissions' => Permission::all(),
            ],
        ]);
    }
}
