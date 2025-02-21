<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hierarchy extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->useLogName('hierarchies')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return "Hierarchy {$eventName}";
            });
    }

    public function subordinatePosting()
    {
        return $this->belongsTo(Posting::class, 'subordinate_id');
    }

    public function supervisorPosting()
    {
        return $this->belongsTo(Posting::class, 'boss_id');
    }

    public function subordinate()
    {
        return $this->hasOneThrough(
            User::class,
            Posting::class,
            'id',
            'id',
            'subordinate_id',
            'user_id'
        );
    }

    public function boss()
    {
        return $this->hasOneThrough(
            User::class,
            Posting::class,
            'id',
            'id',
            'boss_id',
            'user_id'
        );
    }
}
