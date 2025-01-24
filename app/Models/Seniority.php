<?php

namespace App\Models;

use App\Traits\HasComments;
use Spatie\MediaLibrary\HasMedia;

use Spatie\Activitylog\LogOptions;
use App\Observers\SeniorityObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([SeniorityObserver::class])]
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
