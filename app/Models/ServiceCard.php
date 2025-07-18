<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use App\Observers\ServiceCardObserver;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([ServiceCardObserver::class])]
class ServiceCard extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'issue_date' => 'datetime',
            'expiry_date' => 'datetime',
            'status_updated_at' => 'datetime',
            'printed_at' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->useLogName('users')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return "Card {$eventName}";
            });
    }

    public function cards() 
    { 
        return $this->morphMany(Card::class, 'cardable'); 
    }

    public function getLatestCard()
    {
        return $this->cards()
            ->where('status', 'active')
            ->latest('created_at')
            ->first();
    }

    public function designation() 
    { 
        return $this->belongsTo(Designation::class); 
    }

    public function office() 
    { 
        return $this->belongsTo(Office::class); 
    }
}
