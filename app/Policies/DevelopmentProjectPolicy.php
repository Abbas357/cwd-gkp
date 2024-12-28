<?php

namespace App\Policies;

use App\Models\DevelopmentProject;
use App\Models\User;

class DevelopmentProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any developmental project');
    }

    public function view(User $user): bool
    {
        return $user->can('view developmental project');
    }

    public function create(User $user): bool
    {
        return $user->can('create developmental project');
    }

    public function update(User $user, DevelopmentProject $developmentProject): bool
    {
        return $user->can('update developmental project');
    }

    public function delete(User $user, DevelopmentProject $developmentProject): bool
    {
        return $user->can('delete developmental project');
    }

    public function publish(User $user, DevelopmentProject $developmentProject): bool
    {
        return $user->can('publish developmental project');
    }

    public function archive(User $user, DevelopmentProject $developmentProject): bool
    {
        return $user->can('archive developmental project');
    }
}
