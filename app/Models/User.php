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
        return $query->whereHas('profile', function($q) {
            $q->where('featured_on', 'LIKE', '%"Home"%');
        });
    }

    public function scopeFeaturedOnTeam($query)
    {
        return $query->whereHas('profile', function($q) {
            $q->where('featured_on', 'LIKE', '%"Team"%');
        });
    }

    public function scopeFeaturedOnContact($query)
    {
        return $query->whereHas('profile', function($q) {
            $q->where('featured_on', 'LIKE', '%"Contact"%');
        });
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

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'user_id');
    }

    public function vehicleAllotments()
    {
        return $this->hasMany(VehicleAllotment::class, 'user_id');
    }

    public function isAdmin()
    {
        return $this->id === 1;
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function postings()
    {
        return $this->hasMany(Posting::class);
    }

    public function currentPosting()
    {
        return $this->hasOne(Posting::class)->where('is_current', true);
    }

    public function currentDesignation()
    {
        return $this->hasOneThrough(Designation::class, Posting::class, 'user_id', 'id', 'id', 'designation_id')
            ->where('postings.is_current', true);
    }

    public function currentOffice()
    {
        return $this->hasOneThrough(Office::class, Posting::class, 'user_id', 'id', 'id', 'office_id')
            ->where('postings.is_current', true);
    }

    public function getPotentialSupervisors()
    {
        // User must have a current posting and office
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        $office = $this->currentOffice;
        $currentDesignation = $this->currentDesignation;

        // Get parent offices
        $parentOffices = $office->getAncestors();

        // If no parent offices, or user is in top office, return empty collection
        if ($parentOffices->isEmpty()) {
            return collect();
        }

        // Find users in parent offices with appropriate designation
        $potentialSupervisors = collect();

        foreach ($parentOffices as $parentOffice) {
            // Option 1: Get users in direct parent office (simplest approach)
            $supervisors = User::whereHas('currentPosting', function ($query) use ($parentOffice) {
                $query->where('office_id', $parentOffice->id)
                    ->where('is_current', true);
            })->get();

            $potentialSupervisors = $potentialSupervisors->merge($supervisors);
        }

        return $potentialSupervisors;
    }

    public function getDirectSupervisor()
    {
        // User must have a current posting and office
        if (!$this->currentPosting || !$this->currentOffice) {
            return null;
        }

        $office = $this->currentOffice;

        // If no parent office, return null
        if (!$office->parent_id) {
            return null;
        }

        $parentOffice = Office::find($office->parent_id);

        // Find the head of the parent office
        // Assuming the office head is the user with the highest designation level in that office
        $supervisor = User::whereHas('currentPosting', function ($query) use ($parentOffice) {
            $query->where('office_id', $parentOffice->id)
                ->where('is_current', true);
        })
            ->whereHas('currentDesignation', function ($query) {
                // You might want to order by designation level or BPS grade
                // This example assumes higher BPS means higher rank
                $query->orderByDesc('bps');
            })
            ->first();

        return $supervisor;
    }

    public function getSubordinates()
    {
        // User must have a current posting and office
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        $office = $this->currentOffice;

        // Get all descendant offices
        $childOffices = $office->getAllDescendants();

        // If no child offices, check if there are other users in the same office
        // with lower designations/ranks
        if ($childOffices->isEmpty()) {
            $currentDesignation = $this->currentDesignation;

            // If user has no designation, return empty
            if (!$currentDesignation) {
                return collect();
            }

            // Get users in the same office with lower designations
            // This assumes you have a way to determine rank, like BPS
            return User::whereHas('currentPosting', function ($query) use ($office) {
                $query->where('office_id', $office->id)
                    ->where('is_current', true);
            })
                ->whereHas('currentDesignation', function ($query) use ($currentDesignation) {
                    // Assuming lower BPS means lower rank
                    $query->where('bps', '<', $currentDesignation->bps);
                })
                ->where('id', '!=', $this->id)
                ->get();
        }

        // Get all users in descendant offices
        $childOfficeIds = $childOffices->pluck('id')->toArray();

        return User::whereHas('currentPosting', function ($query) use ($childOfficeIds) {
            $query->whereIn('office_id', $childOfficeIds)
                ->where('is_current', true);
        })->get();
    }

    public function getEntireTeam()
    {
        // First get direct subordinates
        $team = $this->getSubordinates();

        // Then recursively get subordinates of subordinates
        foreach ($team as $member) {
            $team = $team->merge($member->getSubordinates());
        }

        return $team->unique('id');
    }

    // Check if a user is a supervisor of another user
    public function isSupervisorOf(User $user)
    {
        // Check if the user is in our team
        return $this->getEntireTeam()->contains('id', $user->id);
    }

    public function reportsTo(User $user)
    {
        // Get potential supervisors
        $supervisors = $this->getPotentialSupervisors();

        // Check if the user is among our potential supervisors
        return $supervisors->contains('id', $user->id);
    }

    // Check if a user is in the same reporting chain (either as supervisor or subordinate)
    public function isInReportingChainWith(User $user)
    {
        return $this->isSupervisorOf($user) || $this->reportsTo($user);
    }

    public function getColleagues()
    {
        // User must have a current posting and office
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        // Get all users in the same office
        return User::whereHas('currentPosting', function ($query) {
            $query->where('office_id', $this->currentOffice->id)
                ->where('is_current', true);
        })
            ->where('id', '!=', $this->id)
            ->get();
    }

    public function getCommonTeamMembersWith(User $user)
    {
        $myTeam = $this->getEntireTeam()->pluck('id')->toArray();
        $theirTeam = $user->getEntireTeam()->pluck('id')->toArray();

        $commonTeamIds = array_intersect($myTeam, $theirTeam);

        return User::whereIn('id', $commonTeamIds)->get();
    }

    public function getCurrentDistrict()
    {
        if (!$this->currentOffice) {
            return null;
        }

        return $this->currentOffice->district;
    }

    //  Get all districts managed by the user's current office
    public function getManagedDistricts()
    {
        if (!$this->currentOffice) {
            return collect();
        }

        return $this->currentOffice->getAllManagedDistricts();
    }

    // Check if user has responsibility for a specific district
    public function hasResponsibilityForDistrict($district)
    {
        if (!$this->currentOffice) {
            return false;
        }

        // Get district ID
        $districtId = $district instanceof District ? $district->id : $district;

        // Check if this user's office or any of its children have this district
        $managedDistricts = $this->getManagedDistricts();

        return $managedDistricts->contains(function ($managedDistrict) use ($districtId) {
            return $managedDistrict->id == $districtId;
        });
    }

    public function districts()
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        // Get direct district from current office
        $districts = collect();
        $directDistrict = $this->currentOffice->district;

        if ($directDistrict) {
            $districts->push($directDistrict);
        }

        // Get districts from subordinate offices
        $childOffices = $this->currentOffice->getAllDescendants();
        foreach ($childOffices as $childOffice) {
            if ($childOffice->district) {
                $districts->push($childOffice->district);
            }
        }

        return $districts->unique('id');
    }

    // Get direct district from current office (if any)
    public function directDistrict()
    {
        return $this->currentOffice ? $this->currentOffice->district : null;
    }

    // Get districts from subordinate offices
    public function subordinateDistricts()
    {
        if (!$this->currentOffice) {
            return collect();
        }

        $districts = collect();
        $childOffices = $this->currentOffice->getAllDescendants();

        foreach ($childOffices as $childOffice) {
            if ($childOffice->district) {
                $districts->push($childOffice->district);
            }
        }

        return $districts->unique('id');
    }

    // Check if user is responsible for a specific district

    public function hasDistrict($district)
    {
        $districtId = $district instanceof \App\Models\District ? $district->id : $district;

        // Get all districts this user is responsible for
        $userDistricts = $this->districts();

        return $userDistricts->contains(function ($userDistrict) use ($districtId) {
            return $userDistrict->id == $districtId;
        });
    }

    // Determine if user is directly assigned to a district
    public function hasDirectDistrict($district)
    {
        $districtId = $district instanceof \App\Models\District ? $district->id : $district;
        $direct = $this->directDistrict();

        return $direct && $direct->id == $districtId;
    }

    // Get district ids as an array
    public function getDistrictIds()
    {
        return $this->districts()->pluck('id')->toArray();
    }
}
