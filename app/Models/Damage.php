<?php

namespace App\Models;

use App\Observers\DamageObserver;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([DamageObserver::class])]
class Damage extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'report_date' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('damages')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Damage {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('before_damage_pictures');
        $this->addMediaCollection('after_damage_pictures');
    }

    protected static function booted()
    {
        static::addGlobalScope('app_session_activity', function (Builder $builder) {
            $builder->where('activity', '=', setting('activity', 'dts'))
                    ->where('session', '=', setting('session', 'dts'));
        });
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function infrastructure()
    {
        return $this->belongsTo(Infrastructure::class);
    }

    public function posting()
    {
        return $this->belongsTo(Posting::class);
    }

    public function damageLogs()
    {
        return $this->hasMany(DamageLog::class, 'damage_id')->orderByDesc('created_at');
    }
}
