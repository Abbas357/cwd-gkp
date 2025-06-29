<?php

namespace App\Policies;

use App\Models\Damage;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DamagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any damage');
    }

    public function create(User $user): bool
    {
        return $user->can('create damage');
    }

    public function view(User $user, Damage $damage): bool
    {
        return $user->can('view damage');
    }

    public function updateField(User $user, Damage $damage): bool
    {
        return $user->can('update field damage');
    }

    public function delete(User $user, Damage $damage): bool
    {
        return $user->can('delete damage');
    }

    public function viewMainReport(User $user): bool
    {
        return $user->can('view main report damage');
    }

    public function viewSituationReport(User $user): bool
    {
        return $user->can('view situation report damage');
    }

    public function viewDistrictWiseReport(User $user): bool
    {
        return $user->can('view district-wise report damage');
    }

    public function viewSettings(User $user): bool
    {
        return $user->can('view settings damage');
    }

    public function updateSettings(User $user): bool
    {
        return $user->can('update settings damage');
    }

    public function initSettings(User $user): bool
    {
        return $user->can('init settings damage');
    }
}
