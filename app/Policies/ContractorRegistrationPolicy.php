<?php
namespace App\Policies;
use App\Models\ContractorRegistration;
use App\Models\User;
use Illuminate\Auth\Access\Response;
class ContractorRegistrationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any contractor');
    }
    
    public function view(User $user, ContractorRegistration $contractorRegistration): bool
    {
        return $user->can('view contractor');
    }
    
    public function update(User $user, ContractorRegistration $contractorRegistration): bool
    {
        return $user->can('update contractor');
    }
    
    public function defer(User $user, ContractorRegistration $contractorRegistration): bool
    {
        return $user->can('defer contractor');
    }
    
    public function approve(User $user, ContractorRegistration $contractorRegistration): bool
    {
        return $user->can('approve contractor');
    }
    
    public function card(User $user, ContractorRegistration $contractorRegistration): bool
    {
        return $user->can('generate contractor card');
    }
    
    public function renew(User $user, ContractorRegistration $contractorRegistration): bool
    {
        return $user->can('renew contractor card');
    }
    
    public function delete(User $user, ContractorRegistration $contractorRegistration): bool
    {
        return $user->can('delete contractor');
    }
}
