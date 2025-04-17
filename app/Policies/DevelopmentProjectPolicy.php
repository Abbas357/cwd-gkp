<?php

namespace App\Policies;

use App\Models\DevelopmentProject;
use App\Models\User;

class DevelopmentProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any development-project');
    }

    public function view(User $user, DevelopmentProject $development_project): bool
    {
        return $user->id === $development_project->user_id || $user->can('view development-project');
    }

    public function create(User $user): bool
    {
        return $user->can('create development-project');
    }

    public function detail(User $user, DevelopmentProject $development_project): bool
    {
        return $user->id === $development_project->user_id || $user->can('view detail development-project');
    }

    public function uploadField(User $user, DevelopmentProject $development_project): bool
    {
        return $user->id === $development_project->user_id || $user->can('update field development-project');
    }

    public function delete(User $user, DevelopmentProject $development_project): bool
    {
        return $user->id === $development_project->user_id || $user->can('delete development-project');
    }

    public function publish(User $user, DevelopmentProject $development_project): bool
    {
        return $user->id === $development_project->user_id || $user->can('publish development-project');
    }

    public function archive(User $user, DevelopmentProject $development_project): bool
    {
        return $user->id === $development_project->user_id || $user->can('archive development-project');
    }

    public function comment(User $user, DevelopmentProject $development_project): bool
    {
        return $user->id === $development_project->user_id || $user->can('post comment development-project');
    }
}
