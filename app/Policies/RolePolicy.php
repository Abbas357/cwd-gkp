<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\Response;

class RolePolicy
{    
    public function viewAny(User $user): bool
    {
        return $user->can('view any role');
    }

    public function create(User $user): bool
    {
        return $user->can('create role');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->can('delete role');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->can('update permission role');
    }

    public function assignRole(User $user): bool
    {
        return $user->can('assign role');
    }

    public function assignPermission(User $user): bool
    {
        return $user->can('assign permission role');
    }
}
