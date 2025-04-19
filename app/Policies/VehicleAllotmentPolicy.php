<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VehicleAllotment;
use Illuminate\Auth\Access\Response;

class VehicleAllotmentPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('view any vehicle-allotment');
    }

    public function create(User $user)
    {
        return $user->can('create vehicle-allotment');
    }
}
