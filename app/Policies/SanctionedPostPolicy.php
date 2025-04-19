<?php

namespace App\Policies;

use App\Models\SanctionedPost;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SanctionedPostPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any sanctioned-post');
    }

    public function create(User $user): bool
    {
        return $user->can('create sanctioned-post');
    }

    public function view(User $user, SanctionedPost $sanctionedPost): bool
    {
        return $user->can('view sanctioned-post');
    }

    public function update(User $user, SanctionedPost $sanctionedPost): bool
    {
        return $user->can('update sanctioned-post');
    }

    public function delete(User $user, SanctionedPost $sanctionedPost): bool
    {
        return $user->can('delete sanctioned-post');
    }

    public function viewAvailablePositions(User $user): bool
    {
        return $user->can('view available positions sanctioned-post');
    }

    public function checkExists(User $user): bool
    {
        return $user->can('check exists sanctioned-post');
    }
}
