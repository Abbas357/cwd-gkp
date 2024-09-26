<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EStandardization extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $guarded = [];

    protected static function booted()
    {
        static::updating(function ($standardization) {
            $changedFields = $standardization->getDirty();

            if (isset($changedFields['approval_status'])) {
                $action = $standardization->approval_status === 1 ? 'approval' : 'rejection';
                $oldStatus = $standardization->getOriginal('approval_status');
                $newStatus = $standardization->approval_status;

                EStandardizationLog::create([
                    's_id' => $standardization->id,
                    'action' => $action,
                    'old_value' => $oldStatus,
                    'new_value' => $newStatus,
                    'action_by' => request()->user()->id,
                    'action_at' => now(),
                ]);

                unset($changedFields['approval_status']);
            }

            foreach ($changedFields as $field => $newValue) {
                $oldValue = $standardization->getOriginal($field);

                EStandardizationLog::create([
                    's_id' => $standardization->id,
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
