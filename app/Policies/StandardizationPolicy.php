<?php

namespace App\Policies;

use App\Models\Standardization;
use App\Models\User;

class StandardizationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any standardization');
    }

    public function view(User $user, Standardization $standardization): bool
    {
        return $user->can('view standardization');
    }

    public function update(User $user, Standardization $standardization): bool
    {
        return $user->can('update standardization');
    }

    public function approve(User $user, Standardization $standardization): bool
    {
        return $user->can('approve standardization');
    }

    public function reject(User $user, Standardization $standardization): bool
    {
        return $user->can('reject standardization');
    }

    public function card(User $user, Standardization $standardization): bool
    {
        return $user->can('generate standardization card');
    }

    public function renew(User $user, Standardization $standardization): bool
    {
        return $user->can('renew standardization card');
    }

    public function delete(User $user, Standardization $standardization): bool
    {
        return $user->can('delete standardization');
    }
}
