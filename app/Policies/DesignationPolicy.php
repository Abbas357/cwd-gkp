<?php

namespace App\Policies;

use App\Models\Designation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DesignationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any designation');
    }

    public function create(User $user): bool
    {
        return $user->can('create designation');
    }

    public function view(User $user, Designation $designation): bool
    {
        return $user->can('view designation');
    }
    
    public function activate(User $user, Designation $designation): bool
    {
        return $user->can('activate designation');
    }

    public function updateField(User $user, Designation $designation): bool
    {
        return $user->can('update field designation');
    }

    public function delete(User $user, Designation $designation): bool
    {
        return $user->can('delete designation');
    }
}
