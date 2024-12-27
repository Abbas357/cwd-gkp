<?php

namespace App\Policies;

use App\Models\User;

class NewsLetterPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any newsletter');
    }

    public function createMassEmail(User $user): bool
    {
        return $user->can('create mass email');
    }

    public function sendMassEmail(User $user): bool
    {
        return $user->can('send mass email');
    }
}
