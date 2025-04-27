<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Observers\MachineryAllocationObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([MachineryAllocationObserver::class])]
class MachineryAllocation extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;
    
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Machinery Allocation')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Machinery Allocation {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('machiery_allocation_orders');
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

    public function machinery()
    {
        return $this->belongsTo(Machinery::class, 'machinery_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function project()
    {
        return $this->belongsTo(Scheme::class, 'project_id');
    }
}
