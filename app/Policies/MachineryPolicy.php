<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Machinery;
use Illuminate\Auth\Access\Response;

class MachineryPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('view any machinery');
    }

    public function view(User $user, Machinery $machinery)
    {
        return $user->can('view machinery');
    }

    public function create(User $user)
    {
        return $user->can('create machinery');
    }

    public function viewHistory(User $user, Machinery $machinery)
    {
        return $user->can('view fistory machinery');
    }

    public function updateField(User $user, Machinery $machinery)
    {
        return $user->can('update field machinery');
    }

    public function uploadFile(User $user, Machinery $machinery)
    {
        return $user->can('upload file machinery');
    }

    public function delete(User $user, Machinery $machinery)
    {
        return $user->can('delete machinery');
    }

    public function viewReports(User $user)
    {
        return $user->can('view reports machinery');
    }
}
