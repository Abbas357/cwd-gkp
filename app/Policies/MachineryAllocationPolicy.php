<?php

namespace App\Policies;

use App\Models\MachineryAllocation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MachineryAllocationPolicy
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
    public function view(User $user, MachineryAllocation $machineryAllocation): bool
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
    public function update(User $user, MachineryAllocation $machineryAllocation): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MachineryAllocation $machineryAllocation): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MachineryAllocation $machineryAllocation): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MachineryAllocation $machineryAllocation): bool
    {
        //
    }
}
