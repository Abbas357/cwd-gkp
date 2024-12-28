<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{    
    public function viewAny(User $user): bool
    {
        return $user->can('view any comment');
    }
    
    public function view(User $user, Comment $comment): bool
    {
        return $user->can('view comment');
    }
    
    public function delete(User $user, Comment $comment): bool
    {
        return $user->can('delete comment');
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
