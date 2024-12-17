<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Seniority extends Model implements HasMedia
{
    use HasFactory, LogsActivity, InteractsWithMedia;

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
            ->logExcept(['id', 'updated_at', 'created_at'])
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

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function publishBy() {
        return $this->belongsTo(User::class, 'published_by');
    }
}
