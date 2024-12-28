<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view any event');
    }

    public function view(User $user, Event $event): bool
    {
        return $user->id === $event->user_id || $user->can('view event');
    }

    public function create(User $user): bool
    {
        return $user->can('create event');
    }

    public function update(User $user, Event $event): bool
    {
        return$user->id === $event->user_id ||  $user->can('update event');
    }

    public function publish(User $user, Event $event): bool
    {
        return $user->id === $event->user_id || $user->can('publish event');
    }

    public function archive(User $user, Event $event): bool
    {
        return $user->id === $event->user_id || $user->can('archive event');
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->id === $event->user_id || $user->can('delete event');
    }
}
