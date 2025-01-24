<?php

namespace App\Observers;

use App\Models\News;
use App\Models\SiteNotification;

class NewsObserver
{
    public function created(News $news): void
    {
        SiteNotification::create([
            'title' => $news->title,
            'url' => route('news.show', $news->slug, false),
            'notifiable_id' => $news->id,
            'notifiable_type' => get_class($news),
        ]);
    }

    public function updated(News $news): void
    {
        if ($news->isDirty('status')) {
            $news->notifications()->withoutGlobalScopes()->update([
                'published_at' => $news->status === 'published' ? $news->published_at : null,
            ]);
        }
    }

    public function deleted(News $news): void
    {
        $news->notifications()->withoutGlobalScopes()->delete();
    }

}
