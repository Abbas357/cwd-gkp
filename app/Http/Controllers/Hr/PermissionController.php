<?php

namespace App\Http\Controllers\Hr;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(10);
        return view('modules.hr.permissions.index', compact('permissions'));
    }

    public function store(StorePermissionRequest $request)
    {
        Permission::create(['name' => $request->name]);
        return to_route('admin.apps.hr.permissions.index')->with('success', 'Permission created.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back()->with('success', 'Permission deleted.');
    }

    public function assignRole(StorePermissionRequest $request, Permission $permission)
    {
        if ($permission->hasRole($request->role)) {
            return back()->with('success', 'Role exists.');
        }
        $permission->assignRole($request->role);
        return back()->with('success', 'Role assigned.');
    }

    public function removeRole(Permission $permission, Role $role)
    {
        if ($permission->hasRole($role)) {
            $permission->removeRole($role);
            return back()->with('success', 'Role removed.');
        }

        return back()->with('success', 'Role not exists.');
    }
}
