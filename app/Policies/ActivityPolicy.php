<?php

namespace App\Policies;

use Spatie\Activitylog\Models\Activity;
use App\Models\User;

class ActivityPolicy {
    
    public function view(User $user): bool
    {
        return $user->can('view activity');  
    }
}
