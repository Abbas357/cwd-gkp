<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{    
    public function viewAny(User $user): bool
    {
        return false;
    }
    
    public function view(User $user): bool
    {
        return false;
    }
    
    public function create(User $user): bool
    {
        return false;
    }
    
    public function update(User $user): bool
    {
        return false;
    }
    
    public function delete(User $user): bool
    {
        return false;
    }
}
