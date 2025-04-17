<?php

namespace App\Policies;

use App\Models\Scheme;
use App\Models\User;

class SchemePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any scheme');
    }

    public function detail(User $user, Scheme $scheme): bool
    {
        return $user->can('view detail scheme');
    }

    public function sync(User $user): bool
    {
        return $user->can('sync schemes');
    }
}
