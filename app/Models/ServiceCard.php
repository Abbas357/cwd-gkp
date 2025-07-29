<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use App\Observers\ServiceCardObserver;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([ServiceCardObserver::class])]
class ServiceCard extends Model implements HasMedia
{
    use HasFactory, LogsActivity, InteractsWithMedia;

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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('covering_letters')
        ->singleFile();
        $this->addMediaCollection('payslips')
        ->singleFile();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posting() 
    {
        return $this->belongsTo(Posting::class);
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
        return $query->where('status', 'active');
    }
    
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
                     ->orWhere('expired_at', '<', now());
    }

    public function scopePrinted($query)
    {
        return $query->whereNotNull('printed_at');
    }
    
    public function isActive()
    {
        return $this->status === 'active' && ($this->expired_at === null || $this->expired_at->isFuture());
    }
    
    public function isExpired()
    {
        return $this->status === 'expired' || 
               ($this->expired_at && $this->expired_at->isPast());
    }
    
    public function canBeRenewed()
    {
        return $this->status === 'active' && $this->isExpired();
    }
    
    public function canBeEdited()
    {
        return !in_array($this->approval_status, ['active', 'rejected']);
    }
}