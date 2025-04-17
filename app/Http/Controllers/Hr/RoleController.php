<?php

namespace App\Http\Controllers\Hr;

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
        return view('modules.hr.acl.roles', compact('roles', 'users'));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create(['name' => $request->name]);
        
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Role created successfully',
                'id' => $role->id,
                'name' => $role->name
            ]);
        }
        
        return redirect()->back()->with('success', 'Role Created successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => 'Role deleted successfully'
            ]);
        }
        
        return back()->with('success', 'Role deleted.');
    }

    public function updateSinglePermission(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permission' => 'required|exists:permissions,name',
            'action' => 'required|in:add,remove'
        ]);

        if ($validated['action'] === 'add') {
            $role->givePermissionTo($validated['permission']);
        } else {
            $role->revokePermissionTo($validated['permission']);
        }

        return response()->json([
            'success' => 'Permission updated',
            'permission_count' => $role->permissions->count()
        ]);
    }

    public function bulkUpdatePermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'updates' => 'required|array',
            'updates.*.name' => 'required|exists:permissions,name',
            'updates.*.checked' => 'required|boolean'
        ]);

        $permissions = collect($validated['updates'])
            ->filter(function ($update) {
                return $update['checked'];
            })
            ->pluck('name')
            ->toArray();

        $role->syncPermissions($permissions);

        return response()->json([
            'success' => 'Permissions updated',
            'permission_count' => $role->permissions->count()
        ]);
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => 'array|exists:permissions,name'
        ]);

        $role->syncPermissions($validated['permissions'] ?? []);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => 'Permissions updated',
                'permission_count' => $role->permissions->count()
            ]);
        }

        return response()->json(['success' => 'Permissions updated']);
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