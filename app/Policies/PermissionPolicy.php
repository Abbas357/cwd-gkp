<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('view any permission');
    }

    public function view(User $user, Permission $permission)
    {
        return $user->can('view permission');
    }

    public function create(User $user)
    {
        return $user->can('create permission');
    }

    public function update(User $user, Permission $permission)
    {
        return $user->can('update permission');
    }

    public function delete(User $user, Permission $permission)
    {
        return $user->can('delete permission');
    }

    public function sync(User $user)
    {
        return $user->can('sync permission');
    }
}