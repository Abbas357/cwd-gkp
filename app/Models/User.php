<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\DB;
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
        $currentPosting = $this->currentPosting;
        return $currentPosting ? $currentPosting->office_id : null;
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

    public function getSubordinatesWithOptions(array $options = [])
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        // Start building the query
        $query = User::query()
            ->select('users.*', 'designations.bps', 'designations.name as designation_name', 'offices.name as office_name', 'offices.type as office_type', 'postings.office_id')
            ->join('postings', 'users.id', '=', 'postings.user_id')
            ->join('designations', 'postings.designation_id', '=', 'designations.id')
            ->join('offices', 'postings.office_id', '=', 'offices.id')
            ->where('postings.is_current', true)
            ->where('users.id', '!=', $this->id);

        // Handle same office only option
        if (!empty($options['same_office_only']) && $options['same_office_only']) {
            $query->where('postings.office_id', $this->currentOffice->id);
            
            // If same office only, filter by BPS less than current user
            if ($this->currentDesignation) {
                $query->where('designations.bps', '<', $this->currentDesignation->bps);
            }
        } else {
            // Get office IDs based on direct_only option
            if (!empty($options['direct_only']) && $options['direct_only']) {
                $officeIds = $this->getDirectSubordinateOfficeIds();
            } else {
                $officeIds = $this->getAllSubordinateOfficeIds();
            }

            // Apply office IDs filter
            if (!empty($officeIds)) {
                $query->whereIn('postings.office_id', $officeIds);
            } else if (empty($options['same_office_only'])) {
                // No subordinate offices and not same office, return empty
                return collect();
            }
        }

        // Filter by office type
        if (!empty($options['office_type'])) {
            $officeTypes = is_array($options['office_type']) ? $options['office_type'] : [$options['office_type']];
            $query->whereIn('offices.type', $officeTypes);
        }

        // Exclude office types
        if (!empty($options['exclude_office_types'])) {
            $query->whereNotIn('offices.type', $options['exclude_office_types']);
        }

        // Filter by specific office IDs
        if (!empty($options['office_ids'])) {
            $query->whereIn('postings.office_id', $options['office_ids']);
        }

        // Filter by BPS value(s)
        if (!empty($options['bps'])) {
            $bpsValues = is_array($options['bps']) ? $options['bps'] : [$options['bps']];
            $query->whereIn('designations.bps', $bpsValues);
        }

        // Filter by BPS range
        if (!empty($options['bps_range'])) {
            if (isset($options['bps_range']['min'])) {
                $query->where('designations.bps', '>=', $options['bps_range']['min']);
            }
            if (isset($options['bps_range']['max'])) {
                $query->where('designations.bps', '<=', $options['bps_range']['max']);
            }
        }

        // Filter by designation IDs
        if (!empty($options['designation_ids'])) {
            $query->whereIn('postings.designation_id', $options['designation_ids']);
        }

        // Filter by designation names (partial match)
        if (!empty($options['designation_names'])) {
            $query->where(function($q) use ($options) {
                foreach ($options['designation_names'] as $name) {
                    $q->orWhere('designations.name', 'LIKE', '%' . $name . '%');
                }
            });
        }

        // Filter by district IDs
        if (!empty($options['district_ids'])) {
            $query->whereIn('offices.district_id', $options['district_ids']);
        }

        // Exclude specific users
        if (!empty($options['exclude_users'])) {
            $query->whereNotIn('users.id', $options['exclude_users']);
        }

        // Filter by gender
        if (!empty($options['gender'])) {
            $query->where('users.gender', $options['gender']);
        }

        // Filter by status (if not using global scope)
        if (!empty($options['status'])) {
            $query->where('users.status', $options['status']);
        }

        // Handle highest ranking only per office
        if (!empty($options['highest_ranking_only']) && $options['highest_ranking_only']) {
            // Subquery to get max BPS per office
            $query->join(DB::raw('(
                SELECT p.office_id, MAX(d.bps) as max_bps
                FROM postings p
                JOIN designations d ON p.designation_id = d.id
                WHERE p.is_current = 1
                GROUP BY p.office_id
            ) as max_bps_per_office'), function($join) {
                $join->on('postings.office_id', '=', 'max_bps_per_office.office_id')
                    ->on('designations.bps', '=', 'max_bps_per_office.max_bps');
            });
        }

        // Handle ordering
        $orderBy = $options['order_by'] ?? 'bps';
        $orderDirection = $options['order_direction'] ?? ($orderBy === 'bps' ? 'desc' : 'asc');

        switch ($orderBy) {
            case 'bps':
                $query->orderBy('designations.bps', $orderDirection);
                break;
            case 'name':
                $query->orderBy('users.name', $orderDirection);
                break;
            case 'designation':
                $query->orderBy('designations.name', $orderDirection);
                break;
            case 'office':
                $query->orderBy('offices.name', $orderDirection);
                break;
            default:
                $query->orderBy('designations.bps', 'desc');
        }

        // Apply limit if specified
        if (!empty($options['limit'])) {
            $query->limit($options['limit']);
        }

        // Get the results
        $subordinates = $query->get();

        // Load additional relations if specified
        if (!empty($options['with_relations'])) {
            $subordinates->load($options['with_relations']);
        }

        return $subordinates;
    }

    private function getDirectSubordinateOfficeIds()
    {
        $directOfficeIds = [];
        $childOffices = $this->currentOffice->children;

        foreach ($childOffices as $childOffice) {
            // Check if office has users
            $hasUsers = Posting::where('office_id', $childOffice->id)
                ->where('is_current', true)
                ->exists();

            if ($hasUsers) {
                $directOfficeIds[] = $childOffice->id;
            } else {
                // If no users, go deeper
                $deeperOfficeIds = $this->getDeepestOfficeIdsWithUsers($childOffice);
                $directOfficeIds = array_merge($directOfficeIds, $deeperOfficeIds);
            }
        }

        return array_unique($directOfficeIds);
    }

    private function getAllSubordinateOfficeIds()
    {
        $allDescendants = $this->currentOffice->getAllDescendants();
        return $allDescendants->pluck('id')->toArray();
    }

    private function getDeepestOfficeIdsWithUsers($office)
    {
        $officeIds = [];

        $hasUsers = Posting::where('office_id', $office->id)
            ->where('is_current', true)
            ->exists();

        if ($hasUsers) {
            return [$office->id];
        }

        $childOffices = $office->children;

        foreach ($childOffices as $childOffice) {
            $deeperOfficeIds = $this->getDeepestOfficeIdsWithUsers($childOffice);
            $officeIds = array_merge($officeIds, $deeperOfficeIds);
        }

        return $officeIds;
    }

    public function getDistrictSubordinatesInBPSRange($minBps = 17, $maxBps = 19)
    {
        return $this->getSubordinatesWithOptions([
            'office_type' => 'District',
            'bps_range' => ['min' => $minBps, 'max' => $maxBps],
            'order_by' => 'bps',
            'order_direction' => 'desc'
        ]);
    }

    public function getHighestRankingSubordinatesByOfficeType($officeTypes)
    {
        return $this->getSubordinatesWithOptions([
            'office_type' => $officeTypes,
            'highest_ranking_only' => true,
            'with_relations' => ['currentOffice', 'currentDesignation']
        ]);
    }

    public function getDirectSubordinatesByDesignation($designationNames)
    {
        return $this->getSubordinatesWithOptions([
            'direct_only' => true,
            'designation_names' => $designationNames,
            'order_by' => 'office'
        ]);
    }

    public function getSameOfficeSubordinatesWithBPS($bps)
    {
        return $this->getSubordinatesWithOptions([
            'same_office_only' => true,
            'bps' => $bps
        ]);
    }

    public function isSupervisorOf(User $user)
    {
        return $this->getEntireTeam()->contains('id', $user->id);
    }

    public function getSubordinatesHighestRanking()
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        $office = $this->currentOffice;
        $childOffices = $office->getAllDescendants();

        if ($childOffices->isEmpty()) {
            // If no child offices, get subordinates from same office with lower BPS
            $currentDesignation = $this->currentDesignation;
            
            if (!$currentDesignation) {
                return collect();
            }

            return User::select('users.*')
                ->join('postings', 'users.id', '=', 'postings.user_id')
                ->join('designations', 'postings.designation_id', '=', 'designations.id')
                ->where('postings.office_id', $office->id)
                ->where('postings.is_current', true)
                ->where('designations.bps', '<', $currentDesignation->bps)
                ->where('users.id', '!=', $this->id)
                ->orderBy('designations.bps', 'desc')
                ->get()
                ->unique('id');
        }

        $childOfficeIds = $childOffices->pluck('id')->toArray();

        // Get highest ranking user per office
        $subordinates = User::select('users.*')
            ->join('postings', 'users.id', '=', 'postings.user_id')
            ->join('designations', 'postings.designation_id', '=', 'designations.id')
            ->whereIn('postings.office_id', $childOfficeIds)
            ->where('postings.is_current', true)
            ->whereIn('designations.bps', function($query) use ($childOfficeIds) {
                $query->select(DB::raw('MAX(designations.bps)'))
                    ->from('postings')
                    ->join('designations', 'postings.designation_id', '=', 'designations.id')
                    ->whereColumn('postings.office_id', 'users_postings.office_id')
                    ->where('postings.is_current', true);
            })
            ->from('postings as users_postings')
            ->get();

        return $subordinates;
    }

    public function getDirectSubordinatesHighestRanking()
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        $office = $this->currentOffice;
        $directSubordinates = collect();
        $childOffices = $office->children;

        foreach ($childOffices as $childOffice) {
            // Get highest ranking user in this child office
            $highestRankingUser = User::select('users.*')
                ->join('postings', 'users.id', '=', 'postings.user_id')
                ->join('designations', 'postings.designation_id', '=', 'designations.id')
                ->where('postings.office_id', $childOffice->id)
                ->where('postings.is_current', true)
                ->orderBy('designations.bps', 'desc')
                ->first();

            if ($highestRankingUser) {
                $directSubordinates->push($highestRankingUser);
            } else {
                // If no users in child office, go deeper to find highest ranking
                $deeperSubordinates = $this->getDeepestDirectSubordinatesHighestRanking($childOffice);
                $directSubordinates = $directSubordinates->merge($deeperSubordinates);
            }
        }

        return $directSubordinates->unique('id');
    }

    protected function getDeepestDirectSubordinatesHighestRanking($office)
    {
        $subordinates = collect();

        // Get highest ranking user in this office
        $highestRankingUser = User::select('users.*')
            ->join('postings', 'users.id', '=', 'postings.user_id')
            ->join('designations', 'postings.designation_id', '=', 'designations.id')
            ->where('postings.office_id', $office->id)
            ->where('postings.is_current', true)
            ->orderBy('designations.bps', 'desc')
            ->first();

        if ($highestRankingUser) {
            return collect([$highestRankingUser]);
        }

        $childOffices = $office->children;

        if ($childOffices->isEmpty()) {
            return collect();
        }

        foreach ($childOffices as $childOffice) {
            $deeperSubordinates = $this->getDeepestDirectSubordinatesHighestRanking($childOffice);
            $subordinates = $subordinates->merge($deeperSubordinates);
        }

        return $subordinates;
    }

    public function getUsersFromSameOffice()
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

    public function getSubordinatesFromSameOffice()
    {
        if (!$this->currentPosting || !$this->currentOffice || !$this->currentDesignation) {
            return collect();
        }

        return User::select('users.*')
            ->join('postings', 'users.id', '=', 'postings.user_id')
            ->join('designations', 'postings.designation_id', '=', 'designations.id')
            ->where('postings.office_id', $this->currentOffice->id)
            ->where('postings.is_current', true)
            ->where('designations.bps', '<', $this->currentDesignation->bps)
            ->where('users.id', '!=', $this->id)
            ->orderBy('designations.bps', 'desc')
            ->get();
    }

    /**
     * Get all users from subordinate offices AND users from the same office
     * This combines subordinates with colleagues
     * 
     * @param array $options Optional filters (same as getSubordinatesWithOptions)
     * @return \Illuminate\Support\Collection
     */
    public function getAllAccessibleUsers(array $options = [])
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        // Get all subordinate office IDs
        $subordinateOfficeIds = $this->getAllSubordinateOfficeIds();
        
        // Add current office ID to include colleagues
        $allOfficeIds = array_merge($subordinateOfficeIds, [$this->currentOffice->id]);
        $allOfficeIds = array_unique($allOfficeIds);

        // Start building the query
        $query = User::query()
            ->select('users.*', 'designations.bps', 'designations.name as designation_name', 'offices.name as office_name', 'offices.type as office_type')
            ->join('postings', 'users.id', '=', 'postings.user_id')
            ->join('designations', 'postings.designation_id', '=', 'designations.id')
            ->join('offices', 'postings.office_id', '=', 'offices.id')
            ->where('postings.is_current', true)
            ->where('users.id', '!=', $this->id) // Exclude self
            ->whereIn('postings.office_id', $allOfficeIds);

        // Apply additional filters from options
        $this->applyFiltersToQuery($query, $options);

        // Get the results
        $users = $query->get();

        // Load additional relations if specified
        if (!empty($options['with_relations'])) {
            $users->load($options['with_relations']);
        }

        return $users;
    }

    /**
     * Get all users including subordinates and colleagues with relationship context
     * This method adds context about the user's relationship to the current user
     * 
     * @param array $options Optional filters
     * @return \Illuminate\Support\Collection
     */
    public function getAllAccessibleUsersWithContext(array $options = [])
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        $users = $this->getAllAccessibleUsers($options);
        
        // Add relationship context to each user
        $currentOfficeId = $this->currentOffice->id;
        $currentBps = $this->currentDesignation ? $this->currentDesignation->bps : 0;
        
        return $users->map(function ($user) use ($currentOfficeId, $currentBps) {
            // Get the office_id from the query result
            $userOfficeId = $user->office_id;
            
            // Determine relationship type
            if ($userOfficeId == $currentOfficeId) {
                // Same office
                if ($user->bps > $currentBps) {
                    $user->relationship_type = 'senior_colleague';
                    $user->relationship_description = 'Senior colleague in same office';
                } elseif ($user->bps < $currentBps) {
                    $user->relationship_type = 'junior_colleague';
                    $user->relationship_description = 'Junior colleague in same office';
                } else {
                    $user->relationship_type = 'peer_colleague';
                    $user->relationship_description = 'Peer colleague in same office';
                }
            } else {
                // Subordinate office
                $user->relationship_type = 'subordinate';
                $user->relationship_description = 'User from subordinate office';
            }
            
            return $user;
        });
    }

    /**
     * Get summary statistics of all accessible users
     * 
     * @return array
     */
    public function getAllAccessibleUsersStats()
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return [
                'total_users' => 0,
                'colleagues' => 0,
                'subordinates' => 0,
                'by_office_type' => [],
                'by_bps' => [],
                'by_designation' => []
            ];
        }

        $allUsers = $this->getAllAccessibleUsers();
        $colleagues = $allUsers->where('office_id', $this->currentOffice->id);
        $subordinates = $allUsers->where('office_id', '!=', $this->currentOffice->id);

        return [
            'total_users' => $allUsers->count(),
            'colleagues' => $colleagues->count(),
            'subordinates' => $subordinates->count(),
            'by_office_type' => $allUsers->groupBy('office_type')->map->count(),
            'by_bps' => $allUsers->groupBy('bps')->map->count()->sortKeysDesc(),
            'by_designation' => $allUsers->groupBy('designation_name')->map->count()
        ];
    }

    /**
     * Get all users grouped by office
     * 
     * @param array $options Optional filters
     * @return \Illuminate\Support\Collection
     */
    public function getAllAccessibleUsersGroupedByOffice(array $options = [])
    {
        $users = $this->getAllAccessibleUsers($options);
        
        return $users->groupBy('office_name')->map(function ($officeUsers, $officeName) {
            return [
                'office_name' => $officeName,
                'office_id' => $officeUsers->first()->postings->first()->office_id,
                'office_type' => $officeUsers->first()->office_type,
                'user_count' => $officeUsers->count(),
                'users' => $officeUsers->sortByDesc('bps')
            ];
        })->sortBy('office_name');
    }

    /**
     * Check if a user is accessible (either colleague or subordinate)
     * 
     * @param User|int $user
     * @return bool
     */
    public function hasAccessToUser($user)
    {
        $userId = $user instanceof User ? $user->id : $user;
        
        $accessibleUserIds = $this->getAllAccessibleUsers()->pluck('id')->toArray();
        
        return in_array($userId, $accessibleUserIds);
    }

    /**
     * Get all users with specific filters for common use cases
     */
    public function getAllSeniorUsers()
    {
        if (!$this->currentDesignation) {
            return collect();
        }
        
        return $this->getAllAccessibleUsers([
            'bps_range' => ['min' => $this->currentDesignation->bps + 1]
        ]);
    }

    public function getAllJuniorUsers()
    {
        if (!$this->currentDesignation) {
            return collect();
        }
        
        return $this->getAllAccessibleUsers([
            'bps_range' => ['max' => $this->currentDesignation->bps - 1]
        ]);
    }

    public function getAllPeerUsers()
    {
        if (!$this->currentDesignation) {
            return collect();
        }
        
        return $this->getAllAccessibleUsers([
            'bps' => $this->currentDesignation->bps
        ]);
    }

    /**
     * Helper method to apply filters to a query
     * (Extracted from getSubordinatesWithOptions for reusability)
     */
    private function applyFiltersToQuery($query, array $options)
    {
        // Filter by office type
        if (!empty($options['office_type'])) {
            $officeTypes = is_array($options['office_type']) ? $options['office_type'] : [$options['office_type']];
            $query->whereIn('offices.type', $officeTypes);
        }

        // Exclude office types
        if (!empty($options['exclude_office_types'])) {
            $query->whereNotIn('offices.type', $options['exclude_office_types']);
        }

        // Filter by BPS value(s)
        if (!empty($options['bps'])) {
            $bpsValues = is_array($options['bps']) ? $options['bps'] : [$options['bps']];
            $query->whereIn('designations.bps', $bpsValues);
        }

        // Filter by BPS range
        if (!empty($options['bps_range'])) {
            if (isset($options['bps_range']['min'])) {
                $query->where('designations.bps', '>=', $options['bps_range']['min']);
            }
            if (isset($options['bps_range']['max'])) {
                $query->where('designations.bps', '<=', $options['bps_range']['max']);
            }
        }

        // Filter by designation IDs
        if (!empty($options['designation_ids'])) {
            $query->whereIn('postings.designation_id', $options['designation_ids']);
        }

        // Filter by designation names (partial match)
        if (!empty($options['designation_names'])) {
            $designationNames = is_array($options['designation_names']) ? $options['designation_names'] : [$options['designation_names']];
            $query->where(function($q) use ($designationNames) {
                foreach ($designationNames as $name) {
                    $q->orWhere('designations.name', 'LIKE', '%' . $name . '%');
                }
            });
        }

        // Filter by district IDs
        if (!empty($options['district_ids'])) {
            $query->whereIn('offices.district_id', $options['district_ids']);
        }

        // Exclude specific users
        if (!empty($options['exclude_users'])) {
            $query->whereNotIn('users.id', $options['exclude_users']);
        }

        // Filter by gender
        if (!empty($options['gender'])) {
            $query->where('users.gender', $options['gender']);
        }

        // Filter by status
        if (!empty($options['status'])) {
            $query->where('users.status', $options['status']);
        }

        // Handle highest ranking only per office
        if (!empty($options['highest_ranking_only']) && $options['highest_ranking_only']) {
            $query->join(DB::raw('(
                SELECT p.office_id, MAX(d.bps) as max_bps
                FROM postings p
                JOIN designations d ON p.designation_id = d.id
                WHERE p.is_current = 1
                GROUP BY p.office_id
            ) as max_bps_per_office'), function($join) {
                $join->on('postings.office_id', '=', 'max_bps_per_office.office_id')
                    ->on('designations.bps', '=', 'max_bps_per_office.max_bps');
            });
        }

        // Handle ordering
        $orderBy = $options['order_by'] ?? 'bps';
        $orderDirection = $options['order_direction'] ?? ($orderBy === 'bps' ? 'desc' : 'asc');

        switch ($orderBy) {
            case 'bps':
                $query->orderBy('designations.bps', $orderDirection);
                break;
            case 'name':
                $query->orderBy('users.name', $orderDirection);
                break;
            case 'designation':
                $query->orderBy('designations.name', $orderDirection);
                break;
            case 'office':
                $query->orderBy('offices.name', $orderDirection);
                break;
            default:
                $query->orderBy('designations.bps', 'desc');
        }

        // Apply limit if specified
        if (!empty($options['limit'])) {
            $query->limit($options['limit']);
        }
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

// $subordinates = $user->getSubordinatesHighestRanking();

// // Get colleagues from same office
// $colleagues = $user->getUsersFromSameOffice();

// // Get subordinates from same office only
// $sameOfficeSubordinates = $user->getSubordinatesFromSameOffice();

// // From an office perspective
// $office = Office::find(1);
// $highestRankingUser = $office->getHighestRankingUser();
// $subordinateOffices = $office->getSubordinateOfficesWithHighestRankingUsers();



// $subordinates = $user->getSubordinatesWithOptions([
//     'office_type' => 'District',
//     'bps_range' => ['min' => 17, 'max' => 19]
// ]);

// // Get highest ranking person from each Tehsil office
// $subordinates = $user->getSubordinatesWithOptions([
//     'office_type' => 'Tehsil',
//     'highest_ranking_only' => true
// ]);

// // Get subordinates from same office with BPS 17
// $subordinates = $user->getSubordinatesWithOptions([
//     'same_office_only' => true,
//     'bps' => 17
// ]);

// // Get direct subordinates only, excluding certain office types
// $subordinates = $user->getSubordinatesWithOptions([
//     'direct_only' => true,
//     'exclude_office_types' => ['Project', 'Authority']
// ]);

// // Complex query: Get female subordinates with BPS 17-19 from District offices
// $subordinates = $user->getSubordinatesWithOptions([
//     'office_type' => 'District',
//     'bps_range' => ['min' => 17, 'max' => 19],
//     'gender' => 'Female',
//     'order_by' => 'name',
//     'with_relations' => ['profile', 'currentOffice']
// ]);

// // Get subordinates with specific designations
// $subordinates = $user->getSubordinatesWithOptions([
//     'designation_names' => ['Engineer', 'Assistant'],
//     'order_by' => 'bps',
//     'order_direction' => 'desc'
// ]);

// // Get top 5 highest ranking subordinates
// $subordinates = $user->getSubordinatesWithOptions([
//     'order_by' => 'bps',
//     'order_direction' => 'desc',
//     'limit' => 5
// ]);

// Get all accessible users (subordinates + colleagues)
// $allUsers = $user->getAllAccessibleUsers();

// // Get all accessible users with filters
// $filteredUsers = $user->getAllAccessibleUsers([
//     'office_type' => ['District', 'Tehsil'],
//     'bps_range' => ['min' => 16, 'max' => 18],
//     'gender' => 'Female'
// ]);

// // Get users with relationship context
// $usersWithContext = $user->getAllAccessibleUsersWithContext();
// foreach ($usersWithContext as $accessibleUser) {
//     echo $accessibleUser->name . ' - ' . $accessibleUser->relationship_description;
// }

// // Get statistics
// $stats = $user->getAllAccessibleUsersStats();
// echo "Total accessible users: " . $stats['total_users'];
// echo "Colleagues: " . $stats['colleagues'];
// echo "Subordinates: " . $stats['subordinates'];

// // Get users grouped by office
// $groupedUsers = $user->getAllAccessibleUsersGroupedByOffice();
// foreach ($groupedUsers as $office) {
//     echo $office['office_name'] . ': ' . $office['user_count'] . ' users';
// }

// // Check if you have access to a specific user
// if ($user->hasAccessToUser($targetUser)) {
//     // You can view/manage this user
// }

// // Get all senior users in your sphere
// $seniors = $user->getAllSeniorUsers();

// // Get highest ranking from each office
// $highestRanking = $user->getAllAccessibleUsers([
//     'highest_ranking_only' => true
// ]);