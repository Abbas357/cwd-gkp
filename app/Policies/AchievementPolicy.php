<?php

namespace App\Policies;

use App\Models\Achievement;
use App\Models\User;

class AchievementPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any achievement');
    }
    
    public function view(User $user, Achievement $achievement): bool
    {
        return $user->id === $achievement->user_id || $user->can('view achievement');
    }
    
    public function create(User $user): bool
    {
        return $user->can('create achievement');
    }
    
    public function update(User $user, Achievement $achievement): bool
    {
        return $user->id === $achievement->user_id || $user->can('update achievement');
    }
    
    public function delete(User $user, Achievement $achievement): bool
    {
        return $user->id === $achievement->user_id || $user->can('delete achievement');
    }
    
    public function publish(User $user, Achievement $achievement): bool
    {
        return $user->id === $achievement->user_id || $user->can('publish achievement');
    }
    
    public function archive(User $user, Achievement $achievement): bool
    {
        return $user->id === $achievement->user_id || $user->can('archive achievement');
    }
}
