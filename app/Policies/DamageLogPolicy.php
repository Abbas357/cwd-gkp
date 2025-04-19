<?php

namespace App\Policies;

use App\Models\DamageLog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DamageLogPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any damage-log');
    }
}
