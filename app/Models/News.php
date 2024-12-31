<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasComments;

use Spatie\Activitylog\Traits\LogsActivity;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity, HasComments;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'views_count', 'content', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->useLogName('news')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return "News {$eventName}";
            });
    }

    protected static function booted()
    {
        static::addGlobalScope('published', function (Builder $builder) {
            $builder->where('status', 'published')->whereNotNull('published_at');
        });

        static::created(function ($news) {
            SiteNotification::create([
                'title' => $news->title,
                'url' => route('news.show', $news->slug, false),
                'notifiable_id' => $news->id,
                'notifiable_type' => get_class($news),
            ]);
        });

        static::updated(function ($news) {
            if ($news->isDirty('status')) {
                $news->notifications()->withoutGlobalScopes()->update([
                    'published_at' => $news->status === 'published' ? $news->published_at : null,
                ]);
            }
        });

        static::deleted(function ($news) {
            $news->notifications()->withoutGlobalScopes()->delete();
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('news_attachments')
        ->singleFile();
    }

    public function resolveRouteBinding($value, $route = null)
    {
        return static::withoutGlobalScopes()->where('id', $value)->firstOrFail();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function publishBy() {
        return $this->belongsTo(User::class, 'published_by');
    }

    public function notifications()
    {
        return $this->morphMany(SiteNotification::class, 'notifiable');
    }

}
