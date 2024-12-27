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
        return $user->can('view seniority');
    }

    public function create(User $user): bool
    {
        return $user->can('create seniority');
    }

    public function delete(User $user, Seniority $seniority): bool
    {
        return $user->can('delete seniority');
    }

    public function publish(User $user, Seniority $seniority): bool
    {
        return $user->can('publish seniority');
    }

    public function archive(User $user, Seniority $seniority): bool
    {
        return $user->can('archive seniority');
    }

    public function updateField(User $user): bool
    {
        return $user->can('update seniority field');
    }

    public function uploadFile(User $user): bool
    {
        return $user->can('upload seniority file');
    }
}
