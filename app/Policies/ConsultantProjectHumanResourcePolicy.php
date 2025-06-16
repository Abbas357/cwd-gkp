<?php

namespace App\Policies;

use App\Models\ConsultantProjectHumanResource;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConsultantProjectHumanResourcePolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }
}
