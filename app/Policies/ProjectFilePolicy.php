<?php

namespace App\Policies;

use App\Models\ProjectFile;
use App\Models\User;

class ProjectFilePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any project-file');
    }

    public function view(User $user, ProjectFile $project_file): bool
    {
        return $user->id === $project_file->published_by || $user->can('view project-file');
    }

    public function create(User $user): bool
    {
        return $user->can('create project-file');
    }

    public function detail(User $user, ProjectFile $project_file): bool
    {
        return $user->id === $project_file->published_by || $user->can('view detail project-file');
    }

    public function uploadField(User $user, ProjectFile $project_file): bool
    {
        return $user->id === $project_file->published_by || $user->can('update field project-file');
    }

    public function uploadFile(User $user, ProjectFile $project_file): bool
    {
        return $user->id === $project_file->published_by || $user->can('upload file project-file');
    }

    public function delete(User $user, ProjectFile $project_file): bool
    {
        return $user->id === $project_file->published_by || $user->can('delete project-file');
    }

    public function publish(User $user, ProjectFile $project_file): bool
    {
        return $user->id === $project_file->published_by || $user->can('publish project-file');
    }

    public function archive(User $user, ProjectFile $project_file): bool
    {
        return $user->id === $project_file->published_by || $user->can('archive project-file');
    }
}
