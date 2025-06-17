<?php

namespace App\Policies;

use App\Models\User;

class SettingPolicy
{
    public function manageCoreSettings(User $user)
    {
        return $user->can('update core settings');
    }

    public function manageDistricts(User $user)
    {
        return $user->can('manage district settings');
    }

    public function viewActivity(User $user)
    {
        return $user->can('view activity settings');
    }

    public function viewLaravelLogs(User $user)
    {
        return $user->can('view laravel logs settings');
    }    
}