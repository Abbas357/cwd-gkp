<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AssetAllotment;
use Illuminate\Auth\Access\Response;

class AssetAllotmentPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('view any asset-allotment');
    }

    public function create(User $user)
    {
        return $user->can('create asset-allotment');
    }
}
