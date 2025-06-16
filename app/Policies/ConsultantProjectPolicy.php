<?php

namespace App\Policies;

use App\Models\ConsultantProject;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConsultantProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }
}
