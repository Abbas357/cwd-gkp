<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;

class VehiclePolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view any vehicle');
    }

    public function view(User $user, Vehicle $vehicle)
    {
        return $user->id === $vehicle->user_id || $user->hasPermissionTo('view vehicle');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create vehicle');
    }

    public function update(User $user, Vehicle $vehicle)
    {
        return $user->id === $vehicle->user_id || $user->hasPermissionTo('update vehicle');
    }

    public function delete(User $user, Vehicle $vehicle)
    {
        return $user->id === $vehicle->user_id || $user->hasPermissionTo('delete vehicle');
    }

    public function manage(User $user)
    {
        return $user->hasPermissionTo('manage vehicles');
    }
}
