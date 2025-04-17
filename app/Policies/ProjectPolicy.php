<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any project');
    }

    public function view(User $user, Project $project): bool
    {
        return $user->can('view project');
    }

    public function create(User $user): bool
    {
        return $user->can('create project');
    }

    public function detail(User $user, Project $project): bool
    {
        return $user->can('detail project');
    }

    public function uploadField(User $user, Project $project): bool
    {
        return $user->can('update field project');
    }

    public function uploadFile(User $user, Project $project): bool
    {
        return $user->can('upload file project');
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->can('delete project');
    }
}
