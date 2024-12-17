<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tender extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'date_of_advertisement' => 'datetime',
            'closing_date' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->useLogName('tender')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return "Tender {$eventName}";
            });
    }

    protected static function booted()
    {
        static::addGlobalScope('published', function (Builder $builder) {
            $builder->where('status', 'published')->whereNotNull('published_at');
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('tender_documents');
        $this->addMediaCollection('tender_eoi_documents');
        $this->addMediaCollection('bidding_documents');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function publishBy() {
        return $this->belongsTo(User::class, 'published_by');
    }

}
