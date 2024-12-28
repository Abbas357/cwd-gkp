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

    public function view(User $user, Scheme $scheme): bool
    {
        return $user->can('view scheme');
    }

    public function sync(User $user): bool
    {
        return $user->can('sync schemes');
    }
}
