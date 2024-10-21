<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class EStandardization extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $guarded = [];

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
                return "Standardization has been {$eventName}";
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
    }
}
