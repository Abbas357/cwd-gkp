<?php

namespace App\Policies;

use App\Models\ConsultantProjectHumanResource;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConsultantProjectHumanResourcePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ConsultantProjectHumanResource $consultantProjectHumanResource): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ConsultantProjectHumanResource $consultantProjectHumanResource): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ConsultantProjectHumanResource $consultantProjectHumanResource): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ConsultantProjectHumanResource $consultantProjectHumanResource): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ConsultantProjectHumanResource $consultantProjectHumanResource): bool
    {
        //
    }
}
