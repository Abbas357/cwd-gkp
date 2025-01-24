<?php

namespace App\Observers;

use App\Models\Tender;
use App\Models\SiteNotification;

class TenderObserver
{
    public function created(Tender $tender): void
    {
        SiteNotification::create([
            'title' => $tender->title,
            'url' => route('tenders.show', $tender->slug, false),
            'notifiable_id' => $tender->id,
            'notifiable_type' => get_class($tender),
        ]);
    }

    public function updated(Tender $tender): void
    {
        if ($tender->isDirty('status')) {
            $tender->notifications()->withoutGlobalScopes()->update([
                'published_at' => $tender->status === 'published' ? $tender->published_at : null,
            ]);
        }
    }

    public function deleted(Tender $tender): void
    {
        $tender->notifications()->withoutGlobalScopes()->delete();
    }
}
