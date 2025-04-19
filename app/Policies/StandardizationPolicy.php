<?php

namespace App\Policies;

use App\Models\Standardization;
use App\Models\User;

class StandardizationPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('view any standardization');
    }

    public function view(User $user, Standardization $standardization)
    {
        return $user->can('view standardization');
    }

    public function approve(User $user, Standardization $standardization)
    {
        return $user->can('approve standardization');
    }

    public function reject(User $user, Standardization $standardization)
    {
        return $user->can('reject standardization');
    }

    public function detail(User $user, Standardization $standardization)
    {
        return $user->can('view detail standardization');
    }

    public function viewCard(User $user, Standardization $standardization)
    {
        return $user->can('view card standardization');
    }

    public function renew(User $user, Standardization $standardization)
    {
        return $user->can('renew standardization');
    }

    public function updateField(User $user, Standardization $standardization)
    {
        return $user->can('update field standardization');
    }

    public function uploadFile(User $user, Standardization $standardization)
    {
        return $user->can('upload file standardization');
    }
}
