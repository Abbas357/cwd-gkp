<?php

namespace App\Policies;

use App\Models\TransferRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TransferRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any transfer-request');
    }

    public function create(User $user): bool
    {
        return $user->can('create transfer-request');
    }

    public function delete(User $user, TransferRequest $transfer_request): bool
    {
        return $user->can('delete transfer-request');
    }

    public function review(User $user, TransferRequest $transfer_request): bool
    {
        return $user->can('review transfer-request');
    }

    public function approve(User $user, TransferRequest $transfer_request): bool
    {
        return $user->can('approve transfer-request');
    }

    public function reject(User $user, TransferRequest $transfer_request): bool
    {
        return $user->can('reject transfer-request');
    }
}
