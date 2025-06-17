<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;

class VehiclePolicy
{
    public function viewAny(User $user)
    {
        return $user->can('view any vehicle');
    }

    public function view(User $user, Vehicle $vehicle)
    {
        return $user->id === $vehicle->user_id || $user->can('view vehicle');
    }

    public function create(User $user)
    {
        return $user->can('create vehicle');
    }

    public function viewHistory(User $user, Vehicle $vehicle)
    {
        return $user->can('view history vehicle');
    }

    public function updateField(User $user, Vehicle $vehicle)
    {
        return $user->id === $vehicle->user_id || $user->can('update field vehicle');
    }

    public function uploadFile(User $user, Vehicle $vehicle)
    {
        return $user->id === $vehicle->user_id || $user->can('upload file vehicle');
    }

    public function delete(User $user, Vehicle $vehicle)
    {
        return $user->id === $vehicle->user_id || $user->can('delete vehicle');
    }

    public function viewReports(User $user)
    {
        return $user->can('view reports vehicle');
    }

    public function viewSettings(User $user): bool
    {
        return $user->can('view settings vehicle');
    }

    public function updateSettings(User $user): bool
    {
        return $user->can('update settings vehicle');
    }

    public function initSettings(User $user): bool
    {
        return $user->can('init settings vehicle');
    }

}