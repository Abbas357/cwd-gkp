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

    public function update(User $user, Page $page): bool
    {
        return $user->can('update page');
    }

    public function delete(User $user, Page $page): bool
    {
        return $user->can('delete page');
    }

    public function activate(User $user, Page $page): bool
    {
        return $user->can('activate page');
    }

    public function updateField(User $user): bool
    {
        return $user->can('update page field');
    }

    public function uploadFile(User $user): bool
    {
        return $user->can('upload page file');
    }
}
