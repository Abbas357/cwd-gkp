<?php

namespace App\Policies;

use App\Models\ConsultantProjectHumanResource;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConsultantProjectHumanResourcePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any consultant hr');
    }

    public function update(User $user): bool
    {
        return $user->can('update consultant hr');
    }
    
    public function upload(User $user): bool
    {
        return $user->can('upload consultant hr');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete consultant hr');
    }
}
