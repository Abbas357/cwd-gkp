<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EStandardization extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia;
    protected $guarded = [];

    protected $keyType = 'string';
    public $incrementing = false; 

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
        
        static::updating(function ($standardization) {
            if ($standardization->isDirty('approval_status')) {
                $action = 'approval';
                $oldStatus = $standardization->getOriginal('approval_status');
                $newStatus = $standardization->approval_status;

                EStandardizationLog::create([
                    'reg_id' => $standardization->id,
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
