<?php

namespace App\Policies;

use App\Models\SecureDocument;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SecureDocumentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any secure-document');
    }

    public function view(User $user, SecureDocument $document): bool
    {
        return $user->id === $document->posting->user->id || $user->can('view secure-document');
    }

    public function create(User $user): bool
    {
        return $user->can('create secure-document');
    }

    public function updateField(User $user, SecureDocument $document): bool
    {
        return $user->id === $document->posting->user->id || $user->can('update field secure-document'); 
    }

    public function uploadFile(User $user, SecureDocument $document): bool
    {
        return $user->id === $document->posting->user->id || $user->can('upload file secure-document');
    }

    public function delete(User $user, SecureDocument $document): bool
    {
        return $user->id === $document->posting->user->id || $user->can('delete secure-document');
    }
}
