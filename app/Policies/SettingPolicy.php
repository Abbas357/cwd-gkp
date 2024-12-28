<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;

class SettingPolicy{
    
    public function view(User $user): bool
    {
        return $user->can('view settings');  
    }
    
    public function update(User $user): bool
    {
        return $user->can('update settings');
    }
}
