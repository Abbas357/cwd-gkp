<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use App\Observers\MachineryObserver;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([MachineryObserver::class])]
class Machinery extends Model  implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('machinery')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Machinery {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('machinery_front_pictures')->singleFile();
        $this->addMediaCollection('machinery_side_pictures')->singleFile();
        $this->addMediaCollection('machinery_control_panel_pictures')->singleFile();
        $this->addMediaCollection('machinery_specification_plate_pictures')->singleFile();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function allocation()
    {
        return $this->hasOne(MachineryAllocation::class)
            ->where('is_current', true);
    }

    public function allocations()
    {
        return $this->hasMany(MachineryAllocation::class)->latest();
    }
}