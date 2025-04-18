<?php

namespace App\Policies;

use App\Models\ContractorWorkExperience;
use App\Models\User;

class ContractorWorkExperiencePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any contaractor-work-experience');
    }

    public function update(User $user): bool
    {
        return $user->can('update contractor-work-experience');
    }

    public function upload(User $user): bool
    {
        return $user->can('upload contractor-work-experience');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete contractor-work-experience');
    }
}
