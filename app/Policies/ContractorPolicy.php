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
    
    public function updateField(User $user, Contractor $contractor): bool
    {
        return $user->can('update field contractor');
    }
    
    public function uploadFile(User $user, Contractor $contractor): bool
    {
        return $user->can('upload file contractor');
    }
}
