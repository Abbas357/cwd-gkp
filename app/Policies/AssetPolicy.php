<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Asset;

class AssetPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('view any asset');
    }

    public function view(User $user, Asset $asset)
    {
        return $user->id === $asset->user_id || $user->can('view asset');
    }

    public function create(User $user)
    {
        return $user->can('create asset');
    }

    public function viewHistory(User $user, Asset $asset)
    {
        return $user->can('view history asset');
    }

    public function updateField(User $user, Asset $asset)
    {
        return $user->id === $asset->user_id || $user->can('update field asset');
    }

    public function uploadFile(User $user, Asset $asset)
    {
        return $user->id === $asset->user_id || $user->can('upload file asset');
    }

    public function delete(User $user, Asset $asset)
    {
        return $user->id === $asset->user_id || $user->can('delete asset');
    }

    public function viewReports(User $user)
    {
        return $user->can('view reports asset');
    }
}