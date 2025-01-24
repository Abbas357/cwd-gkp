<?php

namespace App\Observers;

use App\Models\Seniority;
use App\Models\SiteNotification;

class SeniorityObserver
{
    public function created(Seniority $seniority): void
    {
        SiteNotification::create([
            'title' => $seniority->title,
            'url' => route('seniority.show', $seniority->slug, false),
            'notifiable_id' => $seniority->id,
            'notifiable_type' => get_class($seniority),
        ]);
    }

    public function updated(Seniority $seniority): void
    {
        if ($seniority->isDirty('status')) {
            $seniority->notifications()->withoutGlobalScopes()->update([
                'published_at' => $seniority->status === 'published' ? $seniority->published_at : null,
            ]);
        }
    }

    public function deleted(Seniority $seniority): void
    {
        $seniority->notifications()->withoutGlobalScopes()->delete();
    }
}
