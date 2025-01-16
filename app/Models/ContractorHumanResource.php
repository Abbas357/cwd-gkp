<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;

class ContractorHumanResource extends Model implements HasMedia
{
    use InteractsWithMedia, LogsActivity;

    protected $table = 'contractor_human_resources';

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

    protected static function boot()
    {
        parent::boot();
        static::updating(function ($model) {
            if ($model->isDirty('status')) {
                $model->status_updated_at = now();
                $model->status_updated_by = request()->user()->id ?? null;
            }
        });
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
