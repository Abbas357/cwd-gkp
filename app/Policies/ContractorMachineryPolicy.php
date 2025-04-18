<?php

namespace App\Policies;

use App\Models\ContractorMachinery;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContractorMachineryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any contaractor-machinery');
    }

    public function update(User $user): bool
    {
        return $user->can('update contractor-machinery');
    }

    public function upload(User $user): bool
    {
        return $user->can('upload contractor-machinery');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete contractor-machinery');
    }
}
