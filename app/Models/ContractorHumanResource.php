<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Observers\ContractorHumanResourceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([ContractorHumanResourceObserver::class])]
class ContractorHumanResource extends Model implements HasMedia
{
    use InteractsWithMedia, LogsActivity;

    protected $table = 'contractor_human_resources';

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    
    protected $guarded = [];

    protected static $recordEvents = ['updated', 'deleted'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Contractor Human Resource')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Contractor Human Resource {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('contractor_hr_resumes')->singleFile();
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
