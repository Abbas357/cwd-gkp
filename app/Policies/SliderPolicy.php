<?php

namespace App\Policies;

use App\Models\Slider;
use App\Models\User;

class SliderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view sliders');
    }

    public function view(User $user, Slider $slider): bool
    {
        return $user->id === $slider->user_id
            || $user->can('view sliders');
    }

    public function detail(User $user, Slider $slider): bool
    {
        return $user->id === $slider->user_id
            || $user->can('view sliders');
    }

    public function create(User $user): bool
    {
        return $user->can('create sliders');
    }

    public function update(User $user, Slider $slider): bool
    {
        return $user->id === $slider->user_id
            || $user->can('edit sliders');
    }

    public function updateField(User $user, Slider $slider): bool
    {
        return $user->id === $slider->user_id
            || $user->can('update slider field');
    }

    public function uploadFile(User $user, Slider $slider): bool
    {
        return $user->id === $slider->user_id
            || $user->can('edit sliders');
    }

    public function delete(User $user, Slider $slider): bool
    {
        return $user->id === $slider->user_id
            || $user->can('delete sliders');
    }

    public function publish(User $user, Slider $slider): bool
    {
        return $user->id === $slider->user_id
            || $user->can('publish sliders');
    }

    public function archive(User $user, Slider $slider): bool
    {
        return $user->id === $slider->user_id
            || $user->can('archive sliders');
    }

    public function comments(User $user, Slider $slider): bool
    {
        return $user->id === $slider->user_id
            || $user->can('comments sliders');
    }
}
