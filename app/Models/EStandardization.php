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
            if ($standardization->isDirty('approval_status')) {
                $action = $standardization->approval_status === 1 ? 'approval' : 'rejection';
                $oldStatus = $standardization->getOriginal('approval_status');
                $newStatus = $standardization->approval_status;

                EStandardizationLog::create([
                    's_id' => $standardization->id,
                    'action' => $action,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'action_by' => request()->user()->id,
                    'action_at' => now(),
                ]);
            }
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('secp_certificates');
        $this->addMediaCollection('iso_certificates');
        $this->addMediaCollection('commerse_memberships');
        $this->addMediaCollection('pec_certificates');
        $this->addMediaCollection('annual_tax_returns');
        $this->addMediaCollection('audited_financials');
        $this->addMediaCollection('organization_registrations');
        $this->addMediaCollection('performance_certificate');
    }
}
