<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model implements HasMedia
{
    use HasFactory, LogsActivity, InteractsWithMedia;

    protected $fillable = ['body', 'name', 'email', 'commentable_type', 'commentable_id', 'status', 'published_by', 'published_at', 'parent_id' ,'user_id'];

    protected static $recordEvents = ['updated', 'deleted'];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('comment_attachments')->singleFile();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->useLogName('comments')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return "Comment {$eventName}";
            });
    }

    protected static function booted()
    {
        static::addGlobalScope('published', function (Builder $builder) {
            $builder->where('status', 'published')->whereNotNull('published_at');
        });
    }

    public function resolveRouteBinding($value, $route = null)
    {
        return static::withoutGlobalScopes()->where('id', $value)->firstOrFail();
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id')->nullable();
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function publishBy() {
        return $this->belongsTo(User::class, 'published_by');
    }

}
