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
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'datetime',
            'issue_date' => 'datetime',
            'expiry_date' => 'datetime',
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
        $this->addMediaCollection('service_card_pictures')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);
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
}
