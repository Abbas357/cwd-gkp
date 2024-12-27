<?php

namespace App\Policies;

use App\Models\Download;
use App\Models\User;

class DownloadPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Download $download): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->can('create download');
    }

    public function update(User $user, Download $download): bool
    {
        return $user->id === $download->user_id || $user->can('update download');
    }

    public function delete(User $user, Download $download): bool
    {
        return $user->can('delete download');
    }

    public function publish(User $user, Download $download): bool
    {
        return $user->can('publish download');
    }

    public function archive(User $user, Download $download): bool
    {
        return $user->can('archive download');
    }

    public function updateField(User $user): bool
    {
        return $user->can('update download field');
    }

    public function uploadFile(User $user): bool
    {
        return $user->can('upload download file');
    }
}
