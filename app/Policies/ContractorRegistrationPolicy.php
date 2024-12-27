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
    
    public function view(User $user): bool
    {
        return $user->can('view contractor');
    }
    
    public function create(User $user): bool
    {
        return true;
    }
    
    public function update(User $user): bool
    {
        return $user->can('update contractor');
    }
    
    public function deffer1(User $user): bool
    {
        return $user->can('deffer contractor first time');
    }
    
    public function deffer2(User $user): bool
    {
        return $user->can('deffer contractor second time');
    }
    
    public function approve(User $user): bool
    {
        return $user->can('approve contractor');
    }
    
    public function card(User $user): bool
    {
        return $user->can('generate contractor card');
    }
    
    public function renew(User $user): bool
    {
        return $user->can('renew contractor card');
    }
    
    public function delete(User $user): bool
    {
        return $user->can('delete contractor');
    }
}
