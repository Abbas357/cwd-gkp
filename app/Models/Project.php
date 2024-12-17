<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Project extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('projects')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Project {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('project_documents');
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }
}
