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
        $this->addMediaCollection('before_work_pictures');
        $this->addMediaCollection('after_work_pictures');
    }

    protected static function booted()
    {
        static::addGlobalScope('app_session_activity', function (Builder $builder) {
            $builder->where('activity', '=', setting('activity', 'dmis'))
                    ->where('session', '=', setting('session', 'dmis'));
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

    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            Posting::class,
            'id', // Foreign key on Posting table
            'id', // Foreign key on User table
            'posting_id', // Local key on Damage table
            'user_id' // Local key on Posting table
        );
    }

    public function office()
    {
        return $this->hasOneThrough(
            Office::class,
            Posting::class,
            'id', // Foreign key on Posting table
            'id', // Foreign key on Office table
            'posting_id', // Local key on Damage table
            'office_id' // Local key on Posting table
        );
    }

    public function scopeByOfficer($query, $userId)
    {
        return $query->whereHas('posting', function($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    public function scopeByOffice($query, $officeId)
    {
        return $query->whereHas('posting', function($q) use ($officeId) {
            $q->where('office_id', $officeId);
        });
    }

    public function scopeByInfrastructureType($query, $type)
    {
        return $query->whereHas('infrastructure', function($q) use ($type) {
            $q->where('type', $type);
        });
    }
}
