<?php

namespace App\Policies;

use App\Models\Tender;
use App\Models\User;

class TenderPolicy {

    public function viewAny(User $user): bool
    {
        return $user->can('view any tender');
    }

    public function view(User $user, Tender $tender): bool
    {
        return $user->id === $tender->user_id || $user->can('view tender');
    }

    public function create(User $user): bool
    {
        return $user->can('create tender');
    }

    public function updateField(User $user, Tender $tender): bool
    {
        return $user->id === $tender->user_id || $user->can('update field tender');
    }

    public function delete(User $user, Tender $tender): bool
    {
        return $user->id === $tender->user_id || $user->can('delete tender');
    }

    public function publish(User $user, Tender $tender): bool
    {
        return $user->id === $tender->user_id || $user->can('publish tender');
    }

    public function archive(User $user, Tender $tender): bool
    {
        return $user->id === $tender->user_id || $user->can('archive tender');
    }

    public function comment(User $user): bool
    {
        return $user->can('can comment tender');
    }
}
