<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Builder;

use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_pictures')
            ->singleFile()
            // ->onlyKeepLatest(3)
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);

        $this->addMediaCollection('posting_orders')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'application/pdf']);

        $this->addMediaCollection('exit_orders')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'application/pdf']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit(Fit::Crop, 200, 200)->nonQueued();
        $this->addMediaConversion('small')->width(400)->nonQueued();
        $this->addMediaConversion('medium')->width(800)->nonQueued();
        $this->addMediaConversion('large')->width(1200)->nonQueued();

        // <img 
        //     src="{{ $user->getFirstMediaUrl('images', 'thumb') }}" 
        //     srcset="
        //         {{ $user->getFirstMediaUrl('images', 'thumb') }} 200w, 
        //         {{ $user->getFirstMediaUrl('images', 'small') }} 400w, 
        //         {{ $user->getFirstMediaUrl('images', 'medium') }} 800w, 
        //         {{ $user->getFirstMediaUrl('images', 'large') }} 1200w" 
        //     sizes="(max-width: 600px) 200px, (max-width: 1000px) 400px, (max-width: 1400px) 800px, (max-width: 1800px) 1200px, 1200px"
        //     alt="User image">

    }

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('is_active', 1);
        });
    }

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password_updated_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function logs()
    {
        return $this->hasMany(ActivityLog::class, 'action_by');
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function sliders()
    {
        return $this->hasMany(Slider::class);
    }

    public function boss()
    {
        // $boss = $user->boss->first();
        return $this->belongsToMany(User::class, 'user_hierarchy', 'user_id', 'boss_id');
    }

    public function subordinates()
    {
        // $subordinates = $user->subordinates;
        return $this->belongsToMany(User::class, 'user_hierarchy', 'boss_id', 'user_id');
    }

    public function districts()
    {
        return $this->belongsToMany(District::class, 'district_user', 'user_id', 'district_id');
    }

    public function isAdmin()
    {
        return $this->id === 1;
    }
}
