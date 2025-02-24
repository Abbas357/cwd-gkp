<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Observers\VehicleAllotmentObserver;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([VehicleAllotmentObserver::class])]
class VehicleAllotment extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;
    
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Vehicle Allotments')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Vehicle Allotment {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('vehicle_orders');
    }

    public function getDurationAttribute()
    {
        $startDate = $this->start_date;
        $endDate = $this->end_date ?? Carbon::now();
        if (!$startDate) {
            return null;
        }
        $parts = [];
        $interval = $startDate->diff($endDate);
        if ($interval->y > 0) {
            $parts[] = $interval->y . ' ' . Str::plural('year', $interval->y);
        }
        if ($interval->m > 0) {
            $parts[] = $interval->m . ' ' . Str::plural('month', $interval->m);
        }
        if ($interval->d > 0) {
            $parts[] = $interval->d . ' ' . Str::plural('day', $interval->d);
        }
        return empty($parts) ? '0 days' : implode(', ', $parts);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
