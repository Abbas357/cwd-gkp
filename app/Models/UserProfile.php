<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

// User Profile Model
class UserProfile extends Model
{
    use HasFactory, LogsActivity;

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'datetime',
        ];
    }
    
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->useLogName('profile')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return "User Profile {$eventName}";
            });
    }

    public function profile()
    {
        return $this->belongsTo(User::class);
    }
}
