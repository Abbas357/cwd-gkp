<?php

namespace App\Policies;

use App\Models\ContractorRegistration;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContractorRegistrationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any contractor-registration');
    }

    public function view(User $user, ContractorRegistration $contractor_registration): bool
    {
        return $user->can('view contractor-registration');
    }

    public function defer(User $user, ContractorRegistration $contractor_registration): bool
    {
        return $user->can('defer contractor-registration');
    }

    public function approve(User $user, ContractorRegistration $contractor_registration): bool
    {
        return $user->can('approve contractor-registration');
    }

    public function detail(User $user, ContractorRegistration $contractor_registration): bool
    {
        return $user->can('view detail contractor-registration');
    }

    public function viewCard(User $user, ContractorRegistration $contractor_registration): bool
    {
        return $user->can('view card contractor-registration');
    }

    public function renew(User $user, ContractorRegistration $contractor_registration): bool
    {
        return $user->can('renew contractor-registration');
    }

    public function updateField(User $user, ContractorRegistration $contractor_registration): bool
    {
        return $user->can('update field contractor-registration');
    }

    public function uploadFile(User $user, ContractorRegistration $contractor_registration): bool
    {
        return $user->can('upload file contractor-registration');
    }
}
