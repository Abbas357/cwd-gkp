<?php

namespace App\Http\Controllers\Categories;

use App\Models\User;

use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::whereNotIn('name', ['admin'])->simplePaginate(10);
        $users = User::all();
        return view('categories.roles.index', compact('roles', 'users'));
    }

    public function store(StoreRoleRequest $request)
    {
        Role::create(['name' => $request->name]);
        return to_route('roles.index')->with('success', 'Role Created successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return back()->with('success', 'Role deleted.');
    }

    public function givePermission(StoreRoleRequest $request, Role $role)
    {
        if ($role->hasPermissionTo($request->permission)) {
            return back()->with('success', 'Permission exists.');
        }
        $role->givePermissionTo($request->permission);
        return back()->with('success', 'Permission added.');
    }

    public function revokePermission(Role $role, Permission $permission)
    {
        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
            return back()->with('success', 'Permission revoked.');
        }
        return back()->with('success', 'Permission not exists.');
    }
}
