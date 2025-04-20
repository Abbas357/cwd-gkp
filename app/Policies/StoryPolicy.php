<?php

namespace App\Policies;

use App\Models\Story;
use App\Models\User;

class StoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any story');
    }

    public function view(User $user, Story $story): bool
    {
        return $user->id === $story->user_id || $user->can('view story');
    }

    public function create(User $user): bool
    {
        return $user->can('create story');
    }

    public function update(User $user, Story $story): bool
    {    
       return $user->id === $story->user_id || $user->can('update story');
    }

    public function delete(User $user, Story $story): bool
    {   
        return $user->id === $story->user_id || $user->can('delete story');
    }

    public function publish(User $user, Story $story): bool
    {
        return $user->can('publish story');
    }
}
