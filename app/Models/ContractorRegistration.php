<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ContractorRegistration extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $guarded = [];

    protected static $recordEvents = ['updated', 'deleted'];

    protected function casts(): array
    {
        return [
            'card_issue_date' => 'datetime',
            'card_expiry_date' => 'datetime',
        ];
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('contractor_registrations')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Registration {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cnic_front_attachments')->singleFile();
        $this->addMediaCollection('cnic_back_attachments')->singleFile();
        $this->addMediaCollection('fbr_attachments')->singleFile();
        $this->addMediaCollection('kpra_attachments')->singleFile();
        $this->addMediaCollection('pec_attachments')->singleFile();
        $this->addMediaCollection('form_h_attachments')->singleFile();
        $this->addMediaCollection('pre_enlistment_attachments')->singleFile();
        $this->addMediaCollection('pre_enlistment_attachments')->singleFile();
        $this->addMediaCollection('contractor_pictures')->singleFile();
    }
}
