<?php

namespace App\Policies;

use App\Models\PublicContact;
use App\Models\User;

class PublicContactPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any public contact');
    }

    public function view(User $user, PublicContact $publicContact): bool
    {
        return $user->can('view public contact');
    }

    public function create(User $user): bool
    {
        return $user->can('create public contact');
    }

    public function reliefGrant(User $user, PublicContact $publicContact): bool
    {
        return $user->can('grant relief to public contact');
    }

    public function reliefNotGrant(User $user, PublicContact $publicContact): bool
    {
        return $user->can('deny relief to public contact');
    }

    public function drop(User $user, PublicContact $publicContact): bool
    {
        return $user->can('drop public contact');
    }
}
