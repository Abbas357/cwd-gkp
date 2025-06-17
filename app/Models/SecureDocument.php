<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SecureDocument extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $guarded = [];

    protected static $recordEvents = ['updated', 'deleted'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Secure Document')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Secure Document {$eventName}";
            });
    }

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
        ];
    }
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('secure_document_attachments')->singleFile();
    }

    public function posting() 
    {
        return $this->belongsTo(Posting::class);
    }
}
