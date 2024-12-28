<?php

namespace App\Policies;

use App\Models\ProjectFile;
use App\Models\User;

class ProjectFilePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any project file');
    }

    public function view(User $user, ProjectFile $projectFile): bool
    {
        return $user->can('view project file');
    }

    public function create(User $user): bool
    {
        return $user->can('create project file');
    }

    public function update(User $user, ProjectFile $projectFile): bool
    {
        return $user->can('update project file');
    }

    public function delete(User $user, ProjectFile $projectFile): bool
    {
        return $user->can('delete project file');
    }

    public function publish(User $user, ProjectFile $projectFile): bool
    {
        return $user->can('publish project file');
    }

    public function archive(User $user, ProjectFile $projectFile): bool
    {
        return $user->can('archive project file');
    }
}
