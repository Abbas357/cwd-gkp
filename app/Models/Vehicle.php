<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use App\Observers\VehicleObserver;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([VehicleObserver::class])]
class Vehicle extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('vehicles')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Vehicle {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('vehicle_pictures');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function allotment()
    {
        return $this->hasOne(VehicleAllotment::class)
            ->whereNull('end_date')
            ->latest('created_at');
    }

    public function allotments()
    {
        return $this->hasMany(VehicleAllotment::class)->latest();
    }
}
