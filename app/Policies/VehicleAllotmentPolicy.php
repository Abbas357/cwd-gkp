<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VehicleAllotment;
use Illuminate\Auth\Access\Response;

class VehicleAllotmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view vehicle allotments');
    }

    public function view(User $user, VehicleAllotment $vehicleAllotment): bool
    {
        return $user->id === $vehicleAllotment->vehicle->user_id || $user->hasPermissionTo('view vehicle allotment');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create vehicle allotment');
    }

    public function update(User $user, VehicleAllotment $vehicleAllotment): bool
    {
        return $user->id === $vehicleAllotment->vehicle->user_id || $user->hasPermissionTo('update vehicle allotment');
    }

    public function delete(User $user, VehicleAllotment $vehicleAllotment): bool
    {
        return $user->id === $vehicleAllotment->vehicle->user_id || $user->hasPermissionTo('delete vehicle allotment');
    }
}
