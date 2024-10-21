<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PublicContact extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['name', 'email', 'contact_number', 'cnic', 'message'];

    // protected static $recordEvents = ['deleted'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('public_contacts')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Public contact Message has been {$eventName}";
            });
    }

}
