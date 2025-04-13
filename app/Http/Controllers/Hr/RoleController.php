<?php

namespace App\Http\Controllers\Hr;

use App\Models\User;
use App\Models\Office;
use App\Models\Designation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StoreRoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        $users = User::with(['roles', 'permissions', 'currentPosting', 'currentPosting.designation', 'currentPosting.office'])
            ->paginate(10);
        $offices = Office::orderBy('name')->get();
        $designations = Designation::orderBy('name')->get();

        return view('modules.hr.roles.index', compact(
            'roles',
            'permissions',
            'users',
            'offices',
            'designations'
        ));
    }

    /**
     * Store a newly created role.
     *
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create(['name' => $request->name]);
        
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Role created successfully',
            'role' => $role
        ]);
    }

    /**
     * Remove the specified role.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        $role->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully'
        ]);
    }

    /**
     * Get user roles and permissions.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserData($userId)
    {
        $user = User::with(['roles', 'permissions', 'currentPosting', 'currentPosting.designation', 'currentPosting.office'])
            ->findOrFail($userId);
        
        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->getFirstMediaUrl('profile_pictures', 'thumb') ?: null,
                    'designation' => $user->currentPosting->designation->name ?? null,
                    'office' => $user->currentPosting->office->name ?? null,
                ],
                'roles' => $user->roles,
                'permissions' => $user->permissions
            ]
        ]);
    }

    /**
     * Get all permissions for a role.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Update the permissions for a role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => 'array'
        ]);
        
        $role->syncPermissions($validated['permissions'] ?? []);
        
        return response()->json([
            'success' => true,
            'message' => 'Role permissions updated successfully'
        ]);
    }

    /**
     * Assign a role to a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userId
     * @param  int  $roleId
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignRoleToUser($userId, $roleId)
    {
        $user = User::findOrFail($userId);
        $role = Role::findOrFail($roleId);
        
        $user->assignRole($role);
        
        return response()->json([
            'success' => true,
            'message' => "Role '{$role->name}' assigned to user successfully"
        ]);
    }

    /**
     * Remove a role from a user.
     *
     * @param  int  $userId
     * @param  int  $roleId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeRoleFromUser($userId, $roleId)
    {
        $user = User::findOrFail($userId);
        $role = Role::findOrFail($roleId);
        
        $user->removeRole($role);
        
        return response()->json([
            'success' => true,
            'message' => "Role '{$role->name}' removed from user successfully"
        ]);
    }

    /**
     * Assign a direct permission to a user.
     *
     * @param  int  $userId
     * @param  int  $permissionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignPermissionToUser($userId, $permissionId)
    {
        $user = User::findOrFail($userId);
        $permission = Permission::findOrFail($permissionId);
        
        $user->givePermissionTo($permission);
        
        return response()->json([
            'success' => true,
            'message' => "Permission '{$permission->name}' assigned to user successfully"
        ]);
    }

    /**
     * Remove a direct permission from a user.
     *
     * @param  int  $userId
     * @param  int  $permissionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removePermissionFromUser($userId, $permissionId)
    {
        $user = User::findOrFail($userId);
        $permission = Permission::findOrFail($permissionId);
        
        $user->revokePermissionTo($permission);
        
        return response()->json([
            'success' => true,
            'message' => "Permission '{$permission->name}' removed from user successfully"
        ]);
    }

    /**
     * Filter users by office and designation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterUsers(Request $request)
    {
        $query = User::with(['currentPosting', 'currentPosting.designation', 'currentPosting.office']);
        
        if ($request->filled('office_id')) {
            $query->whereHas('currentPosting', function($q) use ($request) {
                $q->where('office_id', $request->office_id);
            });
        }
        
        if ($request->filled('designation_id')) {
            $query->whereHas('currentPosting', function($q) use ($request) {
                $q->where('designation_id', $request->designation_id);
            });
        }
        
        $users = $query->get();
        
        $formattedUsers = $users->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->getFirstMediaUrl('profile_pictures', 'thumb') ?: null,
                'designation' => $user->currentPosting->designation->name ?? null,
                'office' => $user->currentPosting->office->name ?? null,
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => [
                'users' => $formattedUsers
            ]
        ]);
    }

    /**
     * Bulk assign roles to users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkAssignRoles(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => 'required|json',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'overwrite' => 'nullable|boolean'
        ]);
        
        $userIds = json_decode($validated['user_ids'], true);
        $users = User::whereIn('id', $userIds)->get();
        $roles = Role::whereIn('id', $validated['roles'])->get();
        
        foreach ($users as $user) {
            if ($request->boolean('overwrite')) {
                $user->syncRoles($roles);
            } else {
                foreach ($roles as $role) {
                    $user->assignRole($role);
                }
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Roles assigned to selected users successfully'
        ]);
    }

    /**
     * Bulk assign permissions to users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkAssignPermissions(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => 'required|json',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
            'overwrite' => 'nullable|boolean'
        ]);
        
        $userIds = json_decode($validated['user_ids'], true);
        $users = User::whereIn('id', $userIds)->get();
        $permissions = Permission::whereIn('id', $validated['permissions'])->get();
        
        foreach ($users as $user) {
            if ($request->boolean('overwrite')) {
                $user->syncPermissions($permissions);
            } else {
                foreach ($permissions as $permission) {
                    $user->givePermissionTo($permission);
                }
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Permissions assigned to selected users successfully'
        ]);
    }
}