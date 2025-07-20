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

    public function create(User $user)
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

    // public function viewAny(User $user)
    // {
    //     // Check if user has permission to view service cards
    //     return $user->hasPermissionTo('view service cards') || 
    //            $user->hasRole(['admin', 'focal_person']);
    // }

    // /**
    //  * Determine whether the user can view the model.
    //  */
    // public function view(User $user, ServiceCard $serviceCard)
    // {
    //     // Can view own card
    //     if ($serviceCard->user_id === $user->id) {
    //         return true;
    //     }

    //     // Can view subordinates' cards
    //     if ($user->canApplyServiceCardFor($serviceCard->user)) {
    //         return true;
    //     }

    //     // Admin or specific permission
    //     return $user->hasPermissionTo('view all service cards') || 
    //            $user->hasRole('admin');
    // }

    // /**
    //  * Determine whether the user can create models.
    //  */
    // public function create(User $user)
    // {
    //     return $user->hasPermissionTo('create service cards') || 
    //            $user->hasRole(['admin', 'focal_person']);
    // }

    // /**
    //  * Determine whether the user can update the model.
    //  */
    // public function update(User $user, ServiceCard $serviceCard)
    // {
    //     // Can't update verified or rejected cards
    //     if (in_array($serviceCard->approval_status, ['verified', 'rejected'])) {
    //         return false;
    //     }

    //     // Can update own draft card
    //     if ($serviceCard->user_id === $user->id && $serviceCard->approval_status === 'draft') {
    //         return true;
    //     }

    //     // Focal person can update subordinates' draft cards
    //     if ($user->canApplyServiceCardFor($serviceCard->user) && 
    //         $serviceCard->approval_status === 'draft') {
    //         return true;
    //     }

    //     return $user->hasPermissionTo('edit all service cards') || 
    //            $user->hasRole('admin');
    // }

    // /**
    //  * Determine whether the user can verify the service card.
    //  */
    // public function verify(User $user, ServiceCard $serviceCard)
    // {
    //     return $user->hasPermissionTo('verify service cards') || 
    //            $user->hasRole(['admin', 'verifier']);
    // }

    // /**
    //  * Determine whether the user can reject the service card.
    //  */
    // public function reject(User $user, ServiceCard $serviceCard)
    // {
    //     return $user->hasPermissionTo('reject service cards') || 
    //            $user->hasRole(['admin', 'verifier']);
    // }

    // /**
    //  * Determine whether the user can restore the service card.
    //  */
    // public function restore(User $user, ServiceCard $serviceCard)
    // {
    //     return $user->hasPermissionTo('restore service cards') || 
    //            $user->hasRole('admin');
    // }

    // /**
    //  * Determine whether the user can renew the service card.
    //  */
    // public function renew(User $user, ServiceCard $serviceCard)
    // {
    //     if (!$serviceCard->canBeRenewed()) {
    //         return false;
    //     }

    //     // Can renew own card
    //     if ($serviceCard->user_id === $user->id) {
    //         return true;
    //     }

    //     // Focal person can renew subordinates' cards
    //     if ($user->canApplyServiceCardFor($serviceCard->user)) {
    //         return true;
    //     }

    //     return $user->hasPermissionTo('renew service cards') || 
    //            $user->hasRole(['admin', 'focal_person']);
    // }

    // /**
    //  * Determine whether the user can update card status.
    //  */
    // public function updateStatus(User $user, ServiceCard $serviceCard)
    // {
    //     return $user->hasPermissionTo('manage service card status') || 
    //            $user->hasRole('admin');
    // }

    // /**
    //  * Determine whether the user can view the card.
    //  */
    // public function viewCard(User $user, ServiceCard $serviceCard)
    // {
    //     // Must be verified
    //     if ($serviceCard->approval_status !== 'verified') {
    //         return false;
    //     }

    //     return $this->view($user, $serviceCard);
    // }

    // /**
    //  * Determine whether the user can update fields.
    //  */
    // public function updateField(User $user, ServiceCard $serviceCard)
    // {
    //     return $this->update($user, $serviceCard);
    // }

    // /**
    //  * Determine whether the user can upload files.
    //  */
    // public function uploadFile(User $user, ServiceCard $serviceCard)
    // {
    //     return $this->update($user, $serviceCard);
    // }
}
