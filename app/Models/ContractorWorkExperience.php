<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Observers\ContractorWorkExperienceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([ContractorWorkExperienceObserver::class])]
class ContractorWorkExperience extends Model implements HasMedia
{
    use InteractsWithMedia, LogsActivity;

    protected $table = 'contractor_work_experiences';

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Contractor Work Experience')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Contractor Work Experience {$eventName}";
            });
    }
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('contractor_work_orders')->singleFile();
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
    
}
