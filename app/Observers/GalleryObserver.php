<?php

namespace App\Observers;

use App\Models\Gallery;
use App\Models\SiteNotification;

class GalleryObserver
{
    public function created(Gallery $gallery): void
    {
        SiteNotification::create([
            'title' => $gallery->title,
            'url' => route('gallery.show', $gallery->slug, false),
            'notifiable_id' => $gallery->id,
            'notifiable_type' => get_class($gallery),
        ]);
    }

    public function updated(Gallery $gallery): void
    {
        if ($gallery->isDirty('status')) {
            $gallery->notifications()->withoutGlobalScopes()->update([
                'published_at' => $gallery->status === 'published' ? $gallery->published_at : null,
            ]);
        }
    }

    public function deleted(Gallery $gallery): void
    {
        $gallery->notifications()->withoutGlobalScopes()->delete();
    }

}
