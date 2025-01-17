<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Standardization extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $guarded = [];

    protected static $recordEvents = ['updated', 'deleted'];

    protected function casts(): array
    {
        return [
            'card_issue_date' => 'datetime',
            'card_expiry_date' => 'datetime',
            'password' => 'hashed'
        ];
    }
    
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

    protected static function boot()
    {
        parent::boot();
        static::updating(function ($model) {
            if ($model->isDirty('status')) {
                $model->status_updated_at = now();
                $model->status_updated_by = request()->user()->id ?? null;
            }
            if ($model->isDirty('password')) {
                $model->password_updated_at = now();
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'standardization_id');
    }
}
