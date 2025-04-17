<?php
namespace App\Policies;
use App\Models\Contractor;
use App\Models\User;
use Illuminate\Auth\Access\Response;
class ContractorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any contractor');
    }
    
    public function view(User $user, Contractor $contractor): bool
    {
        return $user->can('view contractor');
    }
    
    public function update(User $user, Contractor $contractor): bool
    {
        return $user->can('update contractor');
    }
    
    public function defer(User $user, Contractor $contractor): bool
    {
        return $user->can('defer contractor');
    }
    
    public function approve(User $user, Contractor $contractor): bool
    {
        return $user->can('approve contractor');
    }
    
    public function card(User $user, Contractor $contractor): bool
    {
        return $user->can('generate contractor card');
    }
    
    public function renew(User $user, Contractor $contractor): bool
    {
        return $user->can('renew contractor card');
    }
    
    public function delete(User $user, Contractor $contractor): bool
    {
        return $user->can('delete contractor');
    }
}
