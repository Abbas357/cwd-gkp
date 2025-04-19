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

}