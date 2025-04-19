<?php

namespace App\Policies;

use App\Models\Office;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OfficePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any office');
    }

    public function create(User $user): bool
    {
        return $user->can('create office');
    }

    public function view(User $user, Office $office): bool
    {
        return $user->can('view office');
    }

    public function detail(User $user, Office $office): bool
    {
        return $user->can('view detail office');
    }

    public function activate(User $user, Office $office): bool
    {
        return $user->can('activate office');
    }

    public function updateField(User $user, Office $office): bool
    {
        return $user->can('update field office');
    }

    public function delete(User $user, Office $office): bool
    {
        return $user->can('delete office');
    }

    public function viewOrganogram(User $user): bool
    {
        return $user->can('view organogram office');
    }
}
