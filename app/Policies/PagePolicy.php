<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;

class PagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any page');
    }

    public function view(User $user, Page $page): bool
    {
        return $user->can('view page');
    }

    public function create(User $user): bool
    {
        return $user->can('create page');
    }
    
    public function updateField(User $user, Page $page): bool
    {
        return $user->can('update field page');
    }

    public function uploadFile(User $user, Page $page): bool
    {
        return $user->can('upload file page');
    }

    public function delete(User $user, Page $page): bool
    {
        return $user->can('delete page');
    }

    public function activate(User $user, Page $page): bool
    {
        return $user->can('activate page');
    }

}
