<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractorRegistration extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected static function booted()
    {
        static::updating(function ($registration) {
            $changedFields = $registration->getDirty();

            if (isset($changedFields['status'])) {
                $action = $registration->status === 4 ? 'approval' : 'deferred';
                $oldStatus = $registration->getOriginal('status');
                $newStatus = $registration->status;

                RegistrationLog::create([
                    'reg_id' => $registration->id,
                    'action' => $action,
                    'old_value' => $oldStatus,
                    'new_value' => $newStatus,
                    'action_by' => request()->user()->id,
                    'action_at' => now(),
                ]);

                unset($changedFields['status']);
            }

            foreach ($changedFields as $field => $newValue) {
                $oldValue = $registration->getOriginal($field);

                RegistrationLog::create([
                    'reg_id' => $registration->id,
                    'action' => 'editing',
                    'field_name' => $field,
                    'old_value' => $oldValue,
                    'new_value' => $newValue,
                    'action_by' => request()->user()->id,
                    'action_at' => now(),
                ]);
            }
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
    }
}
