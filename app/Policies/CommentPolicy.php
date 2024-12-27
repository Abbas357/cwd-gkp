<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{    
    public function viewAny(User $user): bool
    {
        return true;
    }
    
    public function view(User $user, Comment $comment): bool
    {
        return true;
    }
    
    public function create(User $user): bool
    {
        
        return true;
    }
    
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id || $user->can('update comment');
    }
    
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id || $user->can('delete comment');
    }
    
    public function publish(User $user, Comment $comment): bool
    {
        return $user->can('publish comment');
    }
    
    public function archive(User $user, Comment $comment): bool
    {
        return $user->can('archive comment');
    }
}
