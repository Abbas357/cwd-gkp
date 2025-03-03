<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Activitylog\Models\Activity;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia, LogsActivity;

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
            'posting_date' => 'datetime',
            'exit_date' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'views_count', 'password', 'remember_token', 'password_updated_at', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->useLogName('users')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return "User {$eventName}";
            });
    }

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
        //         {{ $user->getFirstMediaUr('images', 'small') }} 400w, 
        //         {{ $user->getFirstMediaUrl('images', 'medium') }} 800w, 
        //         {{ $user->getFirstMediaUrl('images', 'large') }} 1200w" 
        //     sizes="(max-width: 600px) 200px, (max-width: 1000px) 400px, (max-width: 1400px) 800px, (max-width: 1800px) 1200px, 1200px"
        //     alt="User image">

    }

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('status', 'Active');
        });
    }

    public function resolveRouteBinding($value, $route = null)
    {
        return static::withoutGlobalScopes()->where('id', $value)->firstOrFail();
    }

    public function scopeFeaturedOnHome($query)
    {
        return $query->where('featured_on', 'LIKE', '%"Home"%');
    }

    public function scopeFeaturedOnTeam($query)
    {
        return $query->where('featured_on', 'LIKE', '%"Team"%');
    }

    public function scopeFeaturedOnContact($query)
    {
        return $query->where('featured_on', 'LIKE', '%"Contact"%');
    }

    public function logs()
    {
        return $this->hasMany(Activity::class, 'causer_id');
    }
    
    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function seniority()
    {
        return $this->hasMany(Seniority::class);
    }

    public function developmentProjects()
    {
        return $this->hasMany(DevelopmentProject::class);
    }

    public function sliders()
    {
        return $this->hasMany(Slider::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function porms()
    {
        return $this->hasMany(ProvincialOwnReceipt::class);
    }

    public function boss()
    {
        return $this->belongsTo(User::class, 'boss_id');
    }

    public function subordinates()
    {
        return $this->hasMany(User::class, 'boss_id');
    }

    public function subordinatesTree()
    {
        return $this->hasMany(User::class, 'boss_id')->with('allSubordinates');
    }

    public function getAllSubordinates()
    {
        $subordinates = collect();

        foreach ($this->subordinates as $subordinate) {
            $subordinates->push($subordinate);
            $subordinates = $subordinates->merge($subordinate->getAllSubordinates());
        }

        return $subordinates;
    }

    public function hasAncestor($userId)
    {
        $currentBoss = $this->boss;
        while ($currentBoss) {
            if ($currentBoss->id == $userId) {
                return true;
            }
            $currentBoss = $currentBoss->boss;
        }
        return false;
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'user_id');
    }

    public function vehicleAllotments()
    {
        return $this->hasMany(VehicleAllotment::class, 'user_id');
    }
    
    public function districts()
    {
        return $this->belongsToMany(District::class, 'district_user', 'user_id', 'district_id');
    }

    public function isAdmin()
    {
        return $this->id === 1;
    }


    


    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    // All postings (historical and current)
    public function postings()
    {
        return $this->hasMany(Posting::class);
    }

    // Current active posting
    public function currentPosting()
    {
        return $this->hasOne(Posting::class)->where('is_current', true);
    }

    // Get current designation through current posting
    public function currentDesignation()
    {
        return $this->hasOneThrough(Designation::class, Posting::class, 'user_id', 'id', 'id', 'designation_id')
            ->where('postings.is_current', true);
    }

    // Get current office through current posting
    public function currentOffice()
    {
        return $this->hasOneThrough(Office::class, Posting::class, 'user_id', 'id', 'id', 'office_id')
            ->where('postings.is_current', true);
    }

    // Get current districts through current posting
    public function currentDistricts()
    {
        return $this->hasManyThrough(
            District::class,
            'district_posting',
            'posting_id',
            'id',
            'id',
            'district_id'
        )->whereHas('postings', function ($query) {
            $query->where('user_id', $this->id)->where('is_current', true);
        });
    }

    // public function currentDistricts()
    // {
    //     return $this->hasManyThrough(
    //         District::class,
    //         Posting::class,
    //         'user_id', // Foreign key on postings
    //         'id', // Local key on districts
    //         'id', // Local key on users
    //         'id' // District id via district_posting pivot
    //     )->wherePivot('is_current', true);
    // }

    // Get current boss through reporting relationships
    public function currentBoss()
    {
        return $this->hasOneThrough(
            User::class,
            Hierarchy::class,
            'subordinate_id',
            'id',
            'id',
            'boss_id'
        )->whereHas('postings', function ($query) {
            $query->where('id', 'boss_id')->where('is_current', true);
        });
    }

    // Get current subordinates through reporting relationships
    public function currentSubordinates()
    {
        return $this->hasManyThrough(
            User::class,
            Hierarchy::class,
            'boss_id',
            'id',
            'id',
            'subordinate_id'
        )->whereHas('postings', function ($query) {
            $query->where('id', 'subordinate_id')->where('is_current', true);
        });
    }
}
