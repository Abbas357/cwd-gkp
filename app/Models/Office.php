<?php

namespace App\Models;

use App\Models\Posting;
use App\Models\SanctionedPost;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Office extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->useLogName('offices')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return "Office {$eventName}";
            });
    }

    public function parent()
    {
        return $this->belongsTo(Office::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Office::class, 'parent_id');
    }

    public function sanctionedPosts()
    {
        return $this->hasMany(SanctionedPost::class);
    }

    public function postings()
    {
        return $this->hasMany(Posting::class);
    }

    public function currentPostings()
    {
        return $this->hasMany(Posting::class)->where('is_current', true);
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function sanctionedPostsWithVacancies()
    {
        return $this->sanctionedPosts()->withCount(['currentPostings as filled_positions'])
            ->addSelect([
                'vacant_positions' => DB::raw('total_positions - (SELECT COUNT(*) FROM postings WHERE 
                    postings.office_id = sanctioned_posts.office_id AND 
                    postings.designation_id = sanctioned_posts.designation_id AND 
                    postings.is_current = 1)')
            ]);
    }

    public function hasSanctionedPost($designationId)
    {
        return $this->sanctionedPosts()
            ->where('designation_id', $designationId)
            ->exists();
    }

    public function currentUsers()
    {
        return $this->hasManyThrough(
            User::class,
            Posting::class,
            'office_id',
            'id',
            'id',
            'user_id'
        )->where('postings.is_current', true);
    }

    public function getAncestors()
    {
        $ancestors = collect();
        $current = $this;

        while ($current->parent_id) {
            $parent = Office::find($current->parent_id);
            if ($parent) {
                $ancestors->push($parent);
                $current = $parent;
            } else {
                break;
            }
        }

        return $ancestors;
    }

    public function getAllDescendants()
    {        
        $descendants = collect();

        $children = $this->children;
        $descendants = $descendants->merge($children);

        foreach ($children as $child) {
            $descendants = $descendants->merge($child->getAllDescendants());
        }

        return $descendants;
    }

    public function isDescendantOf(Office $office)
    {
        $current = $this;

        while ($current->parent_id) {
            if ($current->parent_id == $office->id) {
                return true;
            }
            $current = Office::find($current->parent_id);
            if (!$current) {
                break;
            }
        }

        return false;
    }

    public function isAncestorOf(Office $office)
    {
        return $office->isDescendantOf($this);
    }

    public function allUsers()
    {
        $descendantIds = $this->getAllDescendants()->pluck('id')->push($this->id);

        return User::whereHas('currentPosting', function ($query) use ($descendantIds) {
            $query->whereIn('office_id', $descendantIds);
        })->get();
    }

    // Direct district relationship - an office can be associated with one district
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    // Get all districts managed by this office (including its children's districts)
    public function getAllManagedDistricts() {    
        if ($this->type === 'Authority') {
            return District::all();
        }

        $managedDistricts = collect();
        
        // Add this office's district if it has one
        if ($this->district_id) {
            $district = District::find($this->district_id);
            if ($district) {
                $managedDistricts->push($district);
            }
        }
        
        // Add districts from child offices
        $childOffices = $this->getAllDescendants();
        foreach ($childOffices as $childOffice) {
            if ($childOffice->district_id) {
                $district = District::find($childOffice->district_id);
                if ($district) {
                    $managedDistricts->push($district);
                }
            }
        }
        
        return $managedDistricts->unique('id');
    }

    public function vehicleAllotments()
    {
        return $this->hasMany(VehicleAllotment::class, 'office_id');
    }

    public function currentVehicleAllotments()
    {
        return $this->hasMany(VehicleAllotment::class, 'office_id')
            ->where('is_current', true);
    }

    public function vehicles()
    {
        return $this->hasManyThrough(
            Vehicle::class,
            VehicleAllotment::class,
            'office_id',
            'id',
            'id',
            'vehicle_id'
        )->whereHas('allotment', function($query) {
            $query->where('is_current', true);
        });
    }

    public function poolVehicles()
    {
        return $this->hasManyThrough(
            Vehicle::class, 
            VehicleAllotment::class,
            'office_id',
            'id',
            'id',
            'vehicle_id'
        )->whereHas('allotment', function($query) {
            $query->where('is_current', true)
                ->where('type', 'Pool');
        });
    }

}
