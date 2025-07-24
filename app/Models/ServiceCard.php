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
            'issued_at' => 'datetime',
            'expired_at' => 'datetime',
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

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function statusUpdatedBy()
    {
        return $this->belongsTo(User::class, 'status_updated_by');
    }
    
    public function getDesignationAttribute()
    {
        return $this->user ? $this->user->currentDesignation : null;
    }
    
    public function getOfficeAttribute()
    {
        return $this->user ? $this->user->currentOffice : null;
    }
    
    public function scopeActive($query)
    {
        return $query->where('card_status', 'active');
    }
    
    public function scopeVerified($query)
    {
        return $query->where('approval_status', 'verified');
    }
    
    public function scopeExpired($query)
    {
        return $query->where('card_status', 'expired')
                     ->orWhere('expired_at', '<', now());
    }
    
    public function isActive()
    {
        return $this->card_status === 'active' && 
               $this->approval_status === 'verified' &&
               ($this->expired_at === null || $this->expired_at->isFuture());
    }
    
    public function isExpired()
    {
        return $this->card_status === 'expired' || 
               ($this->expired_at && $this->expired_at->isPast());
    }
    
    public function canBeRenewed()
    {
        return $this->approval_status === 'verified' && $this->isExpired();
    }
    
    public function canBeEdited()
    {
        return !in_array($this->approval_status, ['verified', 'rejected']);
    }
}