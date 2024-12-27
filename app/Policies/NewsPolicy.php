<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;

class NewsPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any news');
    }

    public function view(User $user, News $news): bool
    {
        return $user->can('view news');
    }

    public function create(User $user): bool
    {
        return $user->can('create news');
    }

    public function update(User $user, News $news): bool
    {
        return $user->id === $news->created_by || $user->can('update news');
    }

    public function delete(User $user, News $news): bool
    {
        return $user->can('delete news');
    }

    public function publish(User $user, News $news): bool
    {
        return $user->can('publish news');
    }

    public function archive(User $user, News $news): bool
    {
        return $user->can('archive news');
    }

    public function updateField(User $user): bool
    {
        return $user->can('update news field');
    }

    public function uploadFile(User $user): bool
    {
        return $user->can('upload news file');
    }
}
