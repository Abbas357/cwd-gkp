<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasComments;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Seniority extends Model implements HasMedia
{
    use HasFactory, LogsActivity, InteractsWithMedia, HasComments;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }
    
    protected static function booted()
    {
        static::addGlobalScope('published', function (Builder $builder) {
            $builder->where('status', 'published')->whereNotNull('published_at');
        });

        static::created(function ($seniority) {
            SiteNotification::create([
                'title' => $seniority->title,
                'url' => route('seniority.show', $seniority->slug, false),
                'notifiable_id' => $seniority->id,
                'notifiable_type' => get_class($seniority),
            ]);
        });

        static::updated(function ($seniority) {
            if ($seniority->isDirty('status')) {
                $seniority->notifications()->withoutGlobalScopes()->update([
                    'published_at' => $seniority->status === 'published' ? $seniority->published_at : null,
                ]);
            }
        });

        static::deleted(function ($seniority) {
            $seniority->notifications()->withoutGlobalScopes()->delete();
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'views_count', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('seniority')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Seniority {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('seniorities')
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
