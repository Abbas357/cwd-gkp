<?php

namespace App\Policies;

use App\Models\PublicContact;
use App\Models\User;

class PublicContactPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any public query');
    }

    public function view(User $user, PublicContact $publicContact): bool
    {
        return $user->can('view public query');
    }

    public function reliefGrant(User $user, PublicContact $publicContact): bool
    {
        return $user->can('grant relief to query');
    }

    public function reliefNotGrant(User $user, PublicContact $publicContact): bool
    {
        return $user->can('deny relief to query');
    }

    public function drop(User $user, PublicContact $publicContact): bool
    {
        return $user->can('drop query');
    }
}
