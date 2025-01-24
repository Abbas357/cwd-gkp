<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Observers\ContractorMachineryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([ContractorMachineryObserver::class])]
class ContractorMachinery extends Model implements HasMedia
{
    use InteractsWithMedia, LogsActivity;
    
    protected $table = 'contractor_machinery';

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Contractor Machinery')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Contractor Machinery {$eventName}";
            });
    }
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('contractor_machinery_docs');
        $this->addMediaCollection('contractor_machinery_pics');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
