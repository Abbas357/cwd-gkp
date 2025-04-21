<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view any permission');
    }

    public function create(User $user): bool
    {
        return $user->can('create permission');
    }

    public function delete(User $user, Permission $permission): bool
    {
        return $user->can('delete permission');
    }
}