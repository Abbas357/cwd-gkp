<?php

namespace App\Policies;

use App\Models\Consultant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConsultantPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }
}
