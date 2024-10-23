<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('is_active', 1);
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'content', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('pages')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Page has been {$eventName}";
            });
    }
}
