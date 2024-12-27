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

    public function update(User $user, Project $project): bool
    {
        return $user->can('update project');
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->can('delete project');
    }
}
