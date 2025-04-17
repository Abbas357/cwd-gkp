<?php

namespace App\Policies;

use App\Models\Gallery;
use App\Models\User;

class GalleryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any gallery');
    }

    public function view(User $user, Gallery $gallery): bool
    {
        return $user->id === $gallery->user_id || $user->can('view gallery');
    }

    public function create(User $user): bool
    {
        return $user->can('create gallery');
    }

    public function detail(User $user, Gallery $gallery): bool
    {
        return $user->id === $gallery->user_id || $user->can('detail gallery');
    }

    public function uploadField(User $user, Gallery $gallery): bool
    {
        return $user->id === $gallery->user_id || $user->can('update field gallery');
    }

    public function uploadFile(User $user, Gallery $gallery): bool
    {
        return $user->id === $gallery->user_id || $user->can('update file gallery');
    }

    public function delete(User $user, Gallery $gallery): bool
    {
        return $user->id === $gallery->user_id || $user->can('delete gallery');
    }

    public function publish(User $user, Gallery $gallery): bool
    {
        return $user->id === $gallery->user_id || $user->can('publish gallery');
    }

    public function archive(User $user, Gallery $gallery): bool
    {
        return $user->id === $gallery->user_id || $user->can('archive gallery');
    }

    public function comment(User $user, Gallery $gallery): bool
    {
        return $user->id === $gallery->user_id || $user->can('comment gallery');
    }
}
