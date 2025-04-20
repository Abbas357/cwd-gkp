<?php

namespace App\Policies;

use App\Models\Seniority;
use App\Models\User;

class SeniorityPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any seniority');
    }

    public function view(User $user, Seniority $seniority): bool
    {
        return $user->id === $seniority->user_id || $user->can('view seniority');
    }

    public function create(User $user): bool
    {
        return $user->can('create seniority');
    }

    public function updateField(User $user, Seniority $seniority): bool
    {
        return $user->id === $seniority->user_id || $user->can('update field seniority');
    }

    public function uploadFile(User $user, Seniority $seniority): bool
    {
        return $user->id === $seniority->user_id || $user->can('upload file seniority');
    }

    public function delete(User $user, Seniority $seniority): bool
    {
        return $user->id === $seniority->user_id || $user->can('delete seniority');
    }

    public function publish(User $user, Seniority $seniority): bool
    {
        return $user->id === $seniority->user_id || $user->can('publish seniority');
    }

    public function archive(User $user): bool
    {
        return $user->can('archive seniority');
    }
}
