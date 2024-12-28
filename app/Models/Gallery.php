<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\HasComments;

class Gallery extends Model implements HasMedia
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
            ->logExcept(['id', 'updated_at', 'description', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('galleries')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Gallery {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/webp',
                'image/jpg',
                'image/png',
                'image/gif'
            ]);

        $this->addMediaCollection('gallery_covers')
            ->singleFile()
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/webp',
                'image/jpg',
                'image/png',
                'image/gif'
            ]);
    }

    protected static function booted()
    {
        static::addGlobalScope('published', function (Builder $builder) {
            $builder->where('status', 'published')->whereNotNull('published_at');
        });

        static::created(function ($gallery) {
            SiteNotification::create([
                'title' => $gallery->title,
                'url' => route('gallery.show', $gallery->slug, false),
                'notifiable_id' => $gallery->id,
                'notifiable_type' => get_class($gallery),
            ]);
        });

        static::updated(function ($gallery) {
            if ($gallery->isDirty('status')) {
                $gallery->notifications()->withoutGlobalScopes()->update([
                    'published_at' => $gallery->status === 'published' ? $gallery->published_at : null,
                ]);
            }
        });

        static::deleted(function ($gallery) {
            $gallery->notifications()->withoutGlobalScopes()->delete();
        });
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
