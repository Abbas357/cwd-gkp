<?php

namespace App\Models;

use App\Models\User;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DevelopmentProject extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'commencement_date' => 'datetime',
            'year_of_completion' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('development_projects')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Development Project has been {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('development_projects_attachments');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function district() {
        return $this->belongsTo(District::class);
    }

    public function chiefEngineer() {
        return $this->belongsTo(User::class, 'ce_id', 'id');
    }

    public function superintendentEngineer() {
        return $this->belongsTo(User::class, 'se_id');
    }

}
