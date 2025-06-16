<?php

namespace App\Policies;

use App\Models\ConsultantHumanResource;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConsultantHumanResourcePolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }
}
