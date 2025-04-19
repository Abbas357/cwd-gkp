<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('view any product');
    }

    public function update(User $user)
    {
        return $user->can('update product');
    }

    public function upload(User $user)
    {
        return $user->can('upload product');
    }

    public function delete(User $user)
    {
        return $user->can('delete product');
    }
}
