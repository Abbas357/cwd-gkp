<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use App\Models\ContractorMachinery;
use App\Models\ContractorHumanResource;

use Illuminate\Database\Eloquent\Model;
use App\Models\ContractorWorkExperience;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contractor extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'status_updated_at' => 'datetime',
            'password_updated_at' => 'datetime',
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
            ->useLogName('contractors')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Registration {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('contractor_pictures')->singleFile();
        $this->addMediaCollection('contractor_cnic_front')->singleFile();
        $this->addMediaCollection('contractor_cnic_back')->singleFile();
    }

    public function humanResources()
    {
        return $this->hasMany(ContractorHumanResource::class, 'contractor_id');
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
    
    public function machinery()
    {
        return $this->hasMany(ContractorMachinery::class, 'contractor_id');
    }
    
    public function workExperiences()
    {
        return $this->hasMany(ContractorWorkExperience::class, 'contractor_id');
    }

    public function registrations()
    {
        return $this->hasMany(ContractorRegistration::class, 'contractor_id');
    }
}
