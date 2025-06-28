<?php

namespace App\Policies;

use App\Models\Consultant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConsultantPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any consultant');
    }

    public function view(User $user): bool
    {
        return $user->can('view consultant');
    }

    public function updateField(User $user): bool
    {
        return $user->can('update field consultant');
    }

    public function updateFile(User $user): bool
    {
        return $user->can('update file consultant');
    }

    public function report(User $user): bool
    {
        return $user->can('view report consultant');
    }
}
