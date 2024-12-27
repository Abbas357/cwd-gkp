<?php

namespace App\Policies;

use App\Models\EStandardization;
use App\Models\User;

class EStandardizationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any standardization');
    }

    public function view(User $user, EStandardization $eStandardization): bool
    {
        return $user->can('view standardization');
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, EStandardization $eStandardization): bool
    {
        return $user->can('update standardization');
    }

    public function approve(User $user): bool
    {
        return $user->can('approve standardization');
    }

    public function reject(User $user): bool
    {
        return $user->can('reject standardization');
    }

    public function card(User $user): bool
    {
        return $user->can('generate standardization card');
    }

    public function renew(User $user): bool
    {
        return $user->can('renew standardization card');
    }

    public function delete(User $user, EStandardization $eStandardization): bool
    {
        return $user->can('delete standardization');
    }
}
