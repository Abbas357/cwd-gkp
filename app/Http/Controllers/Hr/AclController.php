<?php

namespace App\Http\Controllers\Hr;

use App\Models\User;
use App\Models\Office;
use App\Models\Designation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class AclController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        $users = User::with(['roles', 'permissions', 'currentPosting', 'currentPosting.designation', 'currentPosting.office'])
            ->offset(2)->limit(5)->get();
        $offices = Office::orderBy('name')->get();
        $designations = Designation::orderBy('name')->get();

        return view('modules.hr.acl.users', compact(
            'roles',
            'permissions',
            'users',
            'offices',
            'designations'
        ));
    }

    public function searchUsers(Request $request)
    {
        $query = User::with(['currentPosting', 'currentPosting.designation', 'currentPosting.office']);
        
        if ($request->filled('search')) {
            $searchTerm = '%'.$request->search.'%';
            
            $query->where(function($q) use ($searchTerm, $request) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm);
                
                if (!$request->filled('office_id')) {
                    $q->orWhereHas('currentPosting.office', function($officeQuery) use ($searchTerm) {
                        $officeQuery->where('name', 'like', $searchTerm);
                    });
                }
                
                if (!$request->filled('designation_id')) {
                    $q->orWhereHas('currentPosting.designation', function($designationQuery) use ($searchTerm) {
                        $designationQuery->where('name', 'like', $searchTerm);
                    });
                }
            });
        }
        
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

    public function assignRoleToUser($userId, $roleId)
    {
        $user = User::findOrFail($userId);
        $role = Role::findOrFail($roleId);
        
        $user->assignRole($role);
        
        return response()->json([
            'success' => "Role '{$role->name}' assigned to user successfully"
        ]);
    }

    public function removeRoleFromUser($userId, $roleId)
    {
        $user = User::findOrFail($userId);
        $role = Role::findOrFail($roleId);
        
        $user->removeRole($role);
        
        return response()->json([
            'success' => "Role '{$role->name}' removed from user successfully"
        ]);
    }

    public function assignPermissionToUser($userId, $permissionId)
    {
        $user = User::findOrFail($userId);
        $permission = Permission::findOrFail($permissionId);
        
        $user->givePermissionTo($permission);
        
        return response()->json([
            'success' => "Permission '{$permission->name}' assigned to user successfully"
        ]);
    }

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
            'success' => 'Roles assigned to selected users successfully'
        ]);
    }

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
            'success' => 'Permissions assigned to selected users successfully'
        ]);
    }
}