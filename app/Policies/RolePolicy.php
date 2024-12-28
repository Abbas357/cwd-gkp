<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{    
    public function view(User $user): bool
    {
        return false;
    }
}
