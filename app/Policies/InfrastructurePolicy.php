<?php

namespace App\Policies;

use App\Models\Infrastructure;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InfrastructurePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any infrastructure');
    }

    public function create(User $user): bool
    {
        return $user->can('create infrastructure');
    }

    public function view(User $user, Infrastructure $infrastructure): bool
    {
        return $user->can('view infrastructure');
    }

    public function detail(User $user, Infrastructure $infrastructure): bool
    {
        return $user->can('view detail infrastructure');
    }

    public function updateField(User $user, Infrastructure $infrastructure): bool
    {
        return $user->can('update field infrastructure');
    }

    public function delete(User $user, Infrastructure $infrastructure): bool
    {
        return $user->can('delete infrastructure');
    }
}
