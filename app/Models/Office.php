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

    public function formerUsers()
    {
        return $this->hasManyThrough(
            User::class,
            Posting::class,
            'office_id',
            'id',
            'id',
            'user_id'
        )->where('postings.is_current', false)
            ->orderByDesc('postings.end_date');
    }

    public function formerPostings($designationId = null)
    {
        $query = $this->hasMany(Posting::class, 'office_id')
            ->where('is_current', false)
            ->with(['user', 'designation'])
            ->orderByDesc('end_date');

        if ($designationId !== null) {
            $query->where('designation_id', $designationId);
        }

        return $query;
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

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function getAllManagedDistricts()
    {
        if (in_array($this->type, ['Secretariat', 'Provincial', 'Authority', 'Project'])) {
            return District::all();
        }

        $managedDistricts = collect();

        if ($this->district_id) {
            $district = District::find($this->district_id);
            if ($district) {
                $managedDistricts->push($district);
            }
        }

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
        )->whereHas('allotment', function ($query) {
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
        )->whereHas('allotment', function ($query) {
            $query->where('is_current', true)
                ->where('type', 'Pool');
        });
    }

    public function getAncestorsOptimized()
    {
        if (!$this->parent_id) {
            return collect();
        }

        // Use recursive CTE if your database supports it (MySQL 8.0+, PostgreSQL)
        $ancestors = collect();
        $parentIds = [$this->parent_id];

        while (!empty($parentIds)) {
            $parents = Office::whereIn('id', $parentIds)->get();
            $ancestors = $ancestors->merge($parents);
            $parentIds = $parents->where('parent_id', '!=', null)->pluck('parent_id')->toArray();
        }

        return $ancestors;
    }

    public function getAllDescendantsOptimized()
    {
        // Get all descendants in one query using a recursive approach
        $allDescendants = collect();
        $currentLevelIds = [$this->id];

        while (!empty($currentLevelIds)) {
            $children = Office::whereIn('parent_id', $currentLevelIds)->get();

            if ($children->isEmpty()) {
                break;
            }

            $allDescendants = $allDescendants->merge($children);
            $currentLevelIds = $children->pluck('id')->toArray();
        }

        return $allDescendants;
    }

    // OR if you're using MySQL 8.0+ or PostgreSQL, use this CTE version:
    public function getAllDescendantsCTE()
    {
        return Office::from('offices as descendants')
            ->select('descendants.*')
            ->from(DB::raw("(
            WITH RECURSIVE office_tree AS (
                SELECT * FROM offices WHERE parent_id = {$this->id}
                UNION ALL
                SELECT o.* FROM offices o
                INNER JOIN office_tree ot ON o.parent_id = ot.id
            )
            SELECT * FROM office_tree
        ) as descendants"))
            ->get();
    }
}
