<?php

namespace App\Policies;

use App\Models\Posting;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any posting');
    }

    public function create(User $user): bool
    {
        return $user->can('create posting');
    }

    public function view(User $user, Posting $posting): bool
    {
        return $user->can('view posting');
    }

    public function update(User $user, Posting $posting): bool
    {
        return $user->can('update posting');
    }

    public function delete(User $user, Posting $posting): bool
    {
        return $user->can('delete posting');
    }

    public function end(User $user, Posting $posting): bool
    {
        return $user->can('end posting');
    }

    public function checkSanctioned(User $user): bool
    {
        return $user->can('check sanctioned posting');
    }

    public function checkOccupancy(User $user): bool
    {
        return $user->can('check occupancy posting');
    }

    public function viewCurrentOfficers(User $user): bool
    {
        return $user->can('view current officers posting');
    }
}
