<?php

namespace App\Policies;

use App\Models\ProvincialOwnReceipt;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProvincialOwnReceiptPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('view any provincial-own-receipt');
    }

    public function view(User $user, ProvincialOwnReceipt $provincialOwnReceipt)
    {
        return $user->can('view provincial-own-receipt');
    }

    public function create(User $user)
    {
        return $user->can('create provincial-own-receipt');
    }

    public function detail(User $user, ProvincialOwnReceipt $provincialOwnReceipt)
    {
        return $user->can('view detail provincial-own-receipt');
    }

    public function updateField(User $user, ProvincialOwnReceipt $provincialOwnReceipt)
    {
        return $user->can('update field provincial-own-receipt');
    }

    public function uploadFile(User $user, ProvincialOwnReceipt $provincialOwnReceipt)
    {
        return $user->can('upload file provincial-own-receipt');
    }

    public function delete(User $user, ProvincialOwnReceipt $provincialOwnReceipt)
    {
        return $user->can('delete provincial-own-receipt');
    }

    public function viewReports(User $user)
    {
        return $user->can('view reports provincial-own-receipt');
    }
}
