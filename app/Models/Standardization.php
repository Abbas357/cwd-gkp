<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Observers\StandardizationObserver;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([StandardizationObserver::class])]
class Standardization extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'card_issue_date' => 'datetime',
            'card_expiry_date' => 'datetime',
            'password' => 'hashed'
        ];
    }
    
    protected static $recordEvents = ['updated', 'deleted'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('standardization')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Standardization {$eventName}";
            });
    }
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('secp_certificates')->singleFile();
        $this->addMediaCollection('iso_certificates')->singleFile();
        $this->addMediaCollection('commerse_memberships')->singleFile();
        $this->addMediaCollection('pec_certificates')->singleFile();
        $this->addMediaCollection('annual_tax_returns')->singleFile();
        $this->addMediaCollection('audited_financials')->singleFile();
        $this->addMediaCollection('organization_registrations')->singleFile();
        $this->addMediaCollection('performance_certificate')->singleFile();
        $this->addMediaCollection('standardization_firms_pictures')->singleFile();
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'standardization_id');
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
