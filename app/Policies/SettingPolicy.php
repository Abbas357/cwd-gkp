<?php

namespace App\Policies;

use App\Models\User;

class SettingPolicy
{
    public function updateCore(User $user)
    {
        return $user->can('update core settings');
    }

    public function manageMainCategory(User $user)
    {
        return $user->can('manage main category settings');
    }

    public function manageDistricts(User $user)
    {
        return $user->can('manage district settings');
    }

    public function viewActivity(User $user)
    {
        return $user->can('view activity settings');
    }

    // DMIS Settings
    public function viewDmisSettings(User $user): bool
    {
        return $user->can('view settings damage');
    }

    public function updateDmisSettings(User $user): bool
    {
        return $user->can('update settings damage');
    }

    public function initDmisSettings(User $user): bool
    {
        return $user->can('init settings damage');
    }

    // Hr Settings
    public function viewHrSettings(User $user): bool
    {
        return $user->can('view settings hr');
    }

    public function updateHrSettings(User $user): bool
    {
        return $user->can('update settings hr');
    }

    public function initHrSettings(User $user): bool
    {
        return $user->can('init settings hr');
    }

    // Machinery Settings
    public function viewMachinerySettings(User $user): bool
    {
        return $user->can('view settings machinery');
    }

    public function updateMachinerySettings(User $user): bool
    {
        return $user->can('update settings machinery');
    }

    public function initMachinerySettings(User $user): bool
    {
        return $user->can('init settings machinery');
    }

    // Vehicle Settings
    public function viewVehicleSettings(User $user): bool
    {
        return $user->can('view settings vehicle');
    }

    public function updateVehicleSettings(User $user): bool
    {
        return $user->can('update settings vehicle');
    }

    public function initVehicleSettings(User $user): bool
    {
        return $user->can('init settings vehicle');
    }

}