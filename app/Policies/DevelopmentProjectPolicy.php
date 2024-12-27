<?php

namespace App\Policies;

use App\Models\DevelopmentProject;
use App\Models\User;

class DevelopmentProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, DevelopmentProject $developmentProject): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->can('create development project');
    }

    public function update(User $user, DevelopmentProject $developmentProject): bool
    {
        return $user->id === $developmentProject->user_id || $user->can('update development project');
    }

    public function delete(User $user, DevelopmentProject $developmentProject): bool
    {
        return $user->can('delete development project');
    }

    public function publish(User $user, DevelopmentProject $developmentProject): bool
    {
        return $user->can('publish development project');
    }

    public function archive(User $user, DevelopmentProject $developmentProject): bool
    {
        return $user->can('archive development project');
    }
}
