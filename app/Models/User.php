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

        $this->addMediaCollection('users_cnic_front')
            ->singleFile();
        
        $this->addMediaCollection('users_cnic_back')
            ->singleFile();

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
        return $query->whereHas('profile', function ($q) {
            $q->where('featured_on', 'LIKE', '%"Home"%');
        });
    }

    public function scopeFeaturedOnTeam($query)
    {
        return $query->whereHas('profile', function ($q) {
            $q->where('featured_on', 'LIKE', '%"Team"%');
        });
    }

    public function scopeFeaturedOnContact($query)
    {
        return $query->whereHas('profile', function ($q) {
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

    public function serviceCards()
    {
        return $this->hasMany(ServiceCard::class);
    }

    public function activeServiceCard()
    {
        return $this->hasOne(ServiceCard::class)
            ->where('approval_status', 'verified')
            ->where('card_status', 'active')
            ->where(function ($query) {
                $query->whereNull('expired_at')
                    ->orWhere('expired_at', '>', now());
            })
            ->latest();
    }

    public function hasActiveServiceCard()
    {
        return $this->activeServiceCard()->exists();
    }

    public function canApplyServiceCardFor(User $targetUser)
    {
        // Can apply for self
        if ($this->id === $targetUser->id) {
            return true;
        }

        // Can apply for subordinates
        $subordinates = $this->getSubordinates();
        return $subordinates->contains('id', $targetUser->id);
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

    public function currentVehicleAllotments()
    {
        return $this->hasMany(VehicleAllotment::class, 'user_id')
            ->where('is_current', true);
    }

    public function personalVehicles()
    {
        return $this->hasManyThrough(
            Vehicle::class,
            VehicleAllotment::class,
            'user_id',
            'id',
            'id',
            'vehicle_id'
        )->whereHas('allotment', function ($query) {
            $query->where('is_current', true)
                ->whereNot('type', 'Pool');
        });
    }

    public function officePoolVehicles()
    {
        return $this->hasManyThrough(
            Vehicle::class,
            VehicleAllotment::class,
            'office_id',
            'id',
            'office_id',
            'vehicle_id'
        )->whereHas('allotment', function ($query) {
            $query->where('is_current', true)
                ->where('type', 'Pool')
                ->whereNull('user_id');
        });
    }

    public function accessibleVehicles()
    {
        $personalVehicleIds = $this->personalVehicles()->pluck('id');
        $officeVehicleIds = $this->officePoolVehicles()->pluck('id');

        return Vehicle::whereIn('id', $personalVehicleIds->merge($officeVehicleIds));
    }

    public function currentOfficeId()
    {
        return $this->hasOneThrough(
            'office_id',
            Posting::class,
            'user_id',
            'id',
            'id',
            'office_id'
        )->where('is_current', true);
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
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        $office = $this->currentOffice;
        $currentDesignation = $this->currentDesignation;

        $parentOffices = $office->getAncestors();

        if ($parentOffices->isEmpty()) {
            return collect();
        }

        $potentialSupervisors = collect();

        foreach ($parentOffices as $parentOffice) {
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
        if (!$this->currentPosting || !$this->currentOffice) {
            return null;
        }

        $office = $this->currentOffice;

        if (!$office->parent_id) {
            return null;
        }

        $parentOffice = Office::find($office->parent_id);

        $supervisor = User::whereHas('currentPosting', function ($query) use ($parentOffice) {
            $query->where('office_id', $parentOffice->id)
                ->where('is_current', true);
        })
            ->whereHas('currentDesignation', function ($query) {
                $query->orderByDesc('bps');
            })
            ->first();

        return $supervisor;
    }

    public function getSubordinates()
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        $office = $this->currentOffice;

        $childOffices = $office->getAllDescendants();

        if ($childOffices->isEmpty()) {
            $currentDesignation = $this->currentDesignation;

            if (!$currentDesignation) {
                return collect();
            }

            return User::whereHas('currentPosting', function ($query) use ($office) {
                $query->where('office_id', $office->id)
                    ->where('is_current', true);
            })
                ->whereHas('currentDesignation', function ($query) use ($currentDesignation) {
                    $query->where('bps', '<', $currentDesignation->bps);
                })
                ->where('id', '!=', $this->id)
                ->get();
        }

        $childOfficeIds = $childOffices->pluck('id')->toArray();

        return User::whereHas('currentPosting', function ($query) use ($childOfficeIds) {
            $query->whereIn('office_id', $childOfficeIds)
                ->where('is_current', true);
        })->get();
    }


    public function getUsers()
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        if (in_array($this->currentOffice->type, ['Secretariat', 'Provincial', 'Authority', 'Project'])) {
            return User::whereHas('currentPosting')->get();
        }
        
        return $this->getDirectSubordinates();
    }

    public function getDirectSubordinates()
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        $office = $this->currentOffice;
        $directSubordinates = collect();

        $childOffices = $office->children;

        foreach ($childOffices as $childOffice) {
            $usersInChildOffice = User::whereHas('currentPosting', function ($query) use ($childOffice) {
                $query->where('office_id', $childOffice->id)
                    ->where('is_current', true);
            })->get();

            if ($usersInChildOffice->isNotEmpty()) {
                $directSubordinates = $directSubordinates->merge($usersInChildOffice);
            } else {
                $deeperSubordinates = $this->getDeepestDirectSubordinates($childOffice);
                $directSubordinates = $directSubordinates->merge($deeperSubordinates);
            }
        }

        return $directSubordinates->unique('id');
    }

    protected function getDeepestDirectSubordinates($office)
    {
        $subordinates = collect();

        $usersInOffice = User::whereHas('currentPosting', function ($query) use ($office) {
            $query->where('office_id', $office->id)
                ->where('is_current', true);
        })->get();

        if ($usersInOffice->isNotEmpty()) {
            return $usersInOffice;
        }

        $childOffices = $office->children;

        if ($childOffices->isEmpty()) {
            return collect();
        }

        foreach ($childOffices as $childOffice) {
            $deeperSubordinates = $this->getDeepestDirectSubordinates($childOffice);
            $subordinates = $subordinates->merge($deeperSubordinates);
        }

        return $subordinates;
    }

    public function getEntireTeam()
    {
        $team = $this->getSubordinates();

        foreach ($team as $member) {
            $team = $team->merge($member->getSubordinates());
        }

        return $team->unique('id');
    }

    public function isSupervisorOf(User $user)
    {
        return $this->getEntireTeam()->contains('id', $user->id);
    }

    public function reportsTo(User $user)
    {
        $supervisors = $this->getPotentialSupervisors();
        return $supervisors->contains('id', $user->id);
    }

    public function isInReportingChainWith(User $user)
    {
        return $this->isSupervisorOf($user) || $this->reportsTo($user);
    }

    public function getColleagues()
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

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

    public function getManagedDistricts()
    {
        if (!$this->currentOffice) {
            return collect();
        }

        return $this->currentOffice->getAllManagedDistricts();
    }

    public function hasResponsibilityForDistrict($district)
    {
        if (!$this->currentOffice) {
            return false;
        }
        $districtId = $district instanceof District ? $district->id : $district;

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

        if (in_array($this->currentOffice->type, ['Secretariat', 'Provincial', 'Authority', 'Project'])) {
            return District::all();
        }

        $districts = collect();
        $directDistrict = $this->currentOffice->district;

        if ($directDistrict) {
            $districts->push($directDistrict);
        }

        $childOffices = $this->currentOffice->getAllDescendants();
        foreach ($childOffices as $childOffice) {
            if ($childOffice->district) {
                $districts->push($childOffice->district);
            }
        }

        return $districts->unique('id');
    }

    public function directDistrict()
    {
        return $this->currentOffice ? $this->currentOffice->district : null;
    }

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

    public function hasDistrict($district)
    {
        $districtId = $district instanceof \App\Models\District ? $district->id : $district;

        $userDistricts = $this->districts();

        return $userDistricts->contains(function ($userDistrict) use ($districtId) {
            return $userDistrict->id == $districtId;
        });
    }

    public function hasDirectDistrict($district)
    {
        $districtId = $district instanceof \App\Models\District ? $district->id : $district;
        $direct = $this->directDistrict();

        return $direct && $direct->id == $districtId;
    }

    public function getDistrictIds()
    {
        return $this->districts()->pluck('id')->toArray();
    }

    public function transferRequests()
    {
        return $this->hasMany(TransferRequest::class);
    }

    public function createTransferRequest($data)
    {
        $currentPosting = $this->currentPosting;
        
        $transferData = array_merge($data, [
            'user_id' => $this->id,
            'from_office_id' => $currentPosting?->office_id,
            'from_designation_id' => $currentPosting?->designation_id,
            'posting_date' => now(),
        ]);

        return TransferRequest::create($transferData);
    }

}
