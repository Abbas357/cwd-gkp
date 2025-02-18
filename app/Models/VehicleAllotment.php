<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Observers\VehicleAllotmentObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([VehicleAllotmentObserver::class])]
class VehicleAllotment extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
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
