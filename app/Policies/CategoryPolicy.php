<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any category');
    }

    public function view(User $user, Category $category): bool
    {
        return $user->can('view category');
    }
    
    public function create(User $user): bool
    {
        return $user->can('create category');
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->can('delete category');
    }
}
