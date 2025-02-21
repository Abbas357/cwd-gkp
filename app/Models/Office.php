<?php

namespace App\Models;

use App\Models\Posting;
use App\Models\SanctionedPost;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Office extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->useLogName('offices')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return "Office {$eventName}";
            });
    }

    public function parent()
    {
        return $this->belongsTo(Office::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Office::class, 'parent_id');
    }

    public function sanctionedPosts()
    {
        return $this->hasMany(SanctionedPost::class);
    }

    public function postings()
    {
        return $this->hasMany(Posting::class);
    }

    public function currentPostings()
    {
        return $this->hasMany(Posting::class)->where('is_current', true);
    }
}
