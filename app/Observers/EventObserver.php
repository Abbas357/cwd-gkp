<?php

namespace App\Observers;

use App\Models\Event;
use App\Models\SiteNotification;

class EventObserver
{
    public function created(Event $event): void
    {
        SiteNotification::create([
            'title' => $event->title,
            'url' => route('events.show', $event->slug, false),
            'notifiable_id' => $event->id,
            'notifiable_type' => get_class($event),
        ]);
    }

    public function updated(Event $event): void
    {
        if ($event->isDirty('status')) {
            $event->notifications()->withoutGlobalScopes()->update([
                'published_at' => $event->status === 'published' ? $event->published_at : null,
            ]);
        }
    }

    public function deleted(Event $event): void
    {
        $event->notifications()->withoutGlobalScopes()->delete();
    }
}
