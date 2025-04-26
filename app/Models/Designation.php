<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->useLogName('designations')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return "Designation {$eventName}";
            });
    }

    public function sanctionedPosts()
    {
        return $this->hasMany(SanctionedPost::class);
    }

    public function postings()
    {
        return $this->hasMany(Posting::class);
    }

    public function currentOfficers()
    {
        return $this->hasManyThrough(
            User::class,
            Posting::class,
            'designation_id',
            'id',
            'id',
            'user_id'
        )->where('postings.is_current', true);
    }

    public function formerUsers()
    {
        return $this->hasManyThrough(
            User::class,
            Posting::class,
            'designation_id',
            'id',
            'id',
            'user_id'
        )->where('postings.is_current', false)
        ->orderByDesc('postings.end_date');
    }
}
