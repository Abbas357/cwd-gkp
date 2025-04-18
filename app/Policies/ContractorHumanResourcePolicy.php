<?php

namespace App\Policies;

use App\Models\ContractorHumanResource;
use App\Models\User;

class ContractorHumanResourcePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any contaractor-human-resource');
    }

    public function update(User $user): bool
    {
        return $user->can('update contractor-human-resource');
    }

    public function upload(User $user): bool
    {
        return $user->can('upload contractor-human-resource');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete contractor-human-resource');
    }
}
