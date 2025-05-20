<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use App\Observers\AssetObserver;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([AssetObserver::class])]
class Asset extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Assets')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Asset {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('asset_pictures');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function allotment()
    {
        return $this->hasOne(AssetAllotment::class)
            ->where('is_current', 1);
    }

    public function allotments()
    {
        return $this->hasMany(AssetAllotment::class)->latest();
    }
}
