<?php

namespace App\Policies;

use App\Models\ServiceCard;
use App\Models\User;

class ServiceCardPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('view any service-card');
    }

    public function create(User $user)
    {
        return $user->can('create service-card');
    }

    public function view(User $user, ServiceCard $serviceCard)
    {
        return $user->id === $serviceCard->posting->user->id || $user->can('view service-card');
    }

    public function detail(User $user, ServiceCard $serviceCard)
    {
        return $user->id === $serviceCard->posting->user->id || $user->can('detail service-card');
    }

    public function viewCard(User $user)
    {
        return $user->can('view card service-card');
    }

    public function delete(User $user, ServiceCard $serviceCard)
    {
        return $serviceCard->status === 'draft' && ($user->id === $serviceCard->posting->user->id || $user->can('delete service-card'));
    }

    // Actions that can be performed on ServiceCard

    public function pending(User $user)
    {
        return $user->can('pending service-card');
    }

    public function verify(User $user)
    {
        return $user->can('verify service-card');
    }

    public function reject(User $user)
    {
        return $user->can('reject service-card');
    }

    public function restore(User $user, ServiceCard $serviceCard)
    {
        return $user->id === $serviceCard->posting->user->id || $user->can('restore service-card');
    }

    public function renew(User $user)
    {
        return $user->can('renew service-card');
    }

    public function markLost(User $user)
    {
        return $user->can('mark lost service-card');
    }

    public function duplicate(User $user)
    {
        return $user->can('duplicate service-card');
    }

    public function markPrinted(User $user)
    {
        return $user->can('mark printed service-card');
    }

    // User related actions

    public function searchUsers(User $user)
    {
        return $user->can('search users service-card');
    }

    public function createUser(User $user)
    {
        return $user->can('create users service-card');
    }

    public function updateUser(User $user)
    {
        return $user->can('update user service-card');
    }

    public function updateField(User $user, ServiceCard $serviceCard)
    {
        return in_array($serviceCard->status, ['draft', 'rejected']) && ($user->id === $serviceCard->posting->user->id || $user->can('update field service-card'));
    }

    public function uploadFile(User $user, ServiceCard $serviceCard)
    {
        return in_array($serviceCard->status, ['draft', 'rejected']) && ($user->id === $serviceCard->posting->user->id || $user->can('upload file service-card'));
    }
}
