<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use App\Traits\HasComments;

class Event extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity, HasComments;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'start_datetime' => 'datetime',
            'end_datetime' => 'datetime',
            'published_at' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('events')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Event {$eventName}";
            });
    }

    protected static function booted()
    {
        static::addGlobalScope('published', function (Builder $builder) {
            $builder->where('status', 'published')->whereNotNull('published_at');
        });

        static::created(function ($event) {
            SiteNotification::create([
                'title' => $event->title,
                'url' => route('events.show', $event->slug, false),
                'notifiable_id' => $event->id,
                'notifiable_type' => get_class($event),
            ]);
        });

        static::updated(function ($event) {
            if ($event->isDirty('status')) {
                $event->notifications()->withoutGlobalScopes()->update([
                    'published_at' => $event->status === 'published' ? $event->published_at : null,
                ]);
            }
        });

        static::deleted(function ($event) {
            $event->notifications()->withoutGlobalScopes()->delete();
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('events_pictures');
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
