<?php

namespace App\Policies;

use App\Models\ConsultantProject;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConsultantProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any consultant project');
    }

    public function update(User $user): bool
    {
        return $user->can('update consultant project');
    }
    
    public function upload(User $user): bool
    {
        return $user->can('upload consultant project');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete consultant project');
    }
}
