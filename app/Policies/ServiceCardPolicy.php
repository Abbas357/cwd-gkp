<?php

namespace App\Policies;

use App\Models\ServiceCard;
use App\Models\User;

class ServiceCardPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any service card');
    }

    public function view(User $user, ServiceCard $serviceCard): bool
    {
        return $user->can('view service card');
    }

    public function create(User $user): bool
    {
        return $user->can('create service card');
    }

    public function update(User $user, ServiceCard $serviceCard): bool
    {
        return $user->can('update service card');
    }

    public function delete(User $user, ServiceCard $serviceCard): bool
    {
        return $user->can('delete service card');
    }

    public function verify(User $user, ServiceCard $serviceCard): bool
    {
        return $user->can('verify service card');
    }

    public function reject(User $user, ServiceCard $serviceCard): bool
    {
        return $user->can('reject service card');
    }

    public function restore(User $user, ServiceCard $serviceCard): bool
    {
        return $user->can('restore service card');
    }

    public function renew(User $user, ServiceCard $serviceCard): bool
    {
        return $user->can('renew service card');
    }

    public function updateField(User $user): bool
    {
        return $user->can('update service card field');
    }

    public function uploadFile(User $user): bool
    {
        return $user->can('upload service card file');
    }
}
