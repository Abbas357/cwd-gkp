<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractorRegistration extends Model
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected function casts(): array
    {
        return [
            'card_issue_date' => 'datetime',
            'card_expiry_date' => 'datetime',
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
            ->useLogName('Contractor Registration')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Registration {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('fbr_attachments')->singleFile();
        $this->addMediaCollection('kpra_attachments')->singleFile();
        $this->addMediaCollection('pec_attachments')->singleFile();
        $this->addMediaCollection('form_h_attachments')->singleFile();
        $this->addMediaCollection('pre_enlistment_attachments')->singleFile();
        $this->addMediaCollection('pre_enlistment_attachments')->singleFile();
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
