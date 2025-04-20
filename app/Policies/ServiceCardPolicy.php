<?php

namespace App\Policies;

use App\Models\ServiceCard;
use App\Models\User;

class ServiceCardPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('view any service-ard');
    }

    public function create(User $user, ServiceCard $serviceCard)
    {
        return $user->can('create service-card');
    }

    public function view(User $user, ServiceCard $serviceCard)
    {
        return $user->can('view service-card');
    }

    public function viewCard(User $user, ServiceCard $serviceCard)
    {
        return $user->can('view card service-card');
    }

    public function verify(User $user, ServiceCard $serviceCard)
    {
        return $user->can('verify service-card');
    }

    public function reject(User $user, ServiceCard $serviceCard)
    {
        return $user->can('reject service-card');
    }

    public function restore(User $user, ServiceCard $serviceCard)
    {
        return $user->can('restore service-card');
    }

    public function renew(User $user, ServiceCard $serviceCard)
    {
        return $user->can('renew service-card');
    }

    public function updateField(User $user, ServiceCard $serviceCard)
    {
        return $user->can('update field service-card');
    }

    public function uploadFile(User $user, ServiceCard $serviceCard)
    {
        return $user->can('upload file service-card');
    }
}
