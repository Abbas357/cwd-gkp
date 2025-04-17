<?php

namespace App\Policies;

use App\Models\Download;
use App\Models\User;

class DownloadPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any download');
    }

    public function view(User $user, Download $download): bool
    {
        return $user->id === $download->user_id || $user->can('view download');
    }

    public function create(User $user): bool
    {
        return $user->can('create download');
    }

    public function detail(User $user, Download $download): bool
    {
        return $user->id === $download->user_id || $user->can('view detail download');
    }

    public function uploadField(User $user, Download $download): bool
    {
        return $user->id === $download->user_id || $user->can('update field download');
    }

    public function uploadFile(User $user, Download $download): bool
    {
        return $user->id === $download->user_id || $user->can('upload file download');
    }

    public function delete(User $user, Download $download): bool
    {
        return $user->id === $download->user_id || $user->can('delete download');
    }

    public function publish(User $user, Download $download): bool
    {
        return $user->id === $download->user_id || $user->can('publish download');
    }

    public function archive(User $user, Download $download): bool
    {
        return $user->id === $download->user_id || $user->can('archive download');
    }
}
