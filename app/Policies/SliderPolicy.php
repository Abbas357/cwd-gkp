<?php

namespace App\Policies;

use App\Models\Slider;
use App\Models\User;

class SliderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any slider');
    }

    public function view(User $user, Slider $slider): bool
    {
        return $user->id === $slider->user_id || $user->can('view slider');
    }

    public function create(User $user): bool
    {
        return $user->can('create slider');
    }

    public function update(User $user, Slider $slider): bool
    {
        return $user->id === $slider->user_id || $user->can('update slider');
    }

    public function delete(User $user, Slider $slider): bool
    {
        return $user->id === $slider->user_id || $user->can('delete slider');
    }

    public function publish(User $user, Slider $slider): bool
    {
        return $user->id === $slider->user_id || $user->can('publish slider');
    }

    public function archive(User $user, Slider $slider): bool
    {
        return $user->id === $slider->user_id || $user->can('archive slider');
    }
}
