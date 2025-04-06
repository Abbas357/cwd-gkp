<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view settings');
    }
    
    public function view(User $user, Setting $setting = null)
    {
        return $user->hasPermissionTo('view settings');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('manage settings');
    }
    
    public function update(User $user, Setting $setting = null)
    {
        return $user->hasPermissionTo('manage settings');
    }
    
    public function delete(User $user, Setting $setting = null)
    {
        return $user->hasPermissionTo('manage settings');
    }
}