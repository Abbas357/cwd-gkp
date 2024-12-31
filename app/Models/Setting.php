<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $fillable = [
        'site_name', 'description', 'email', 'maintenance_mode', 'contact_phone', 'contact_address',
        'whatsapp', 'facebook', 'twitter', 'youtube', 'meta_description', 'secret_key',
    ];

    protected static $recordEvents = ['updated'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logExcept(['id', 'views_count', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->useLogName('settings')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return "Setting {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('logo')
            ->singleFile();
        $this
            ->addMediaCollection('favicon')
            ->singleFile();
    }
}