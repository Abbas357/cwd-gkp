<?php

namespace App\Policies;

use App\Models\MachineryAllocation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MachineryAllocationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any machinery-allocation');
    }

    public function create(User $user): bool
    {
        return $user->can('create machinery-allocation');
    }
}
