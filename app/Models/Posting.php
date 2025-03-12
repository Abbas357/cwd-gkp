<?php

namespace App\Models;

use App\Models\User;
use App\Models\Office;
use App\Models\District;
use App\Models\Hierarchy;
use App\Models\Designation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Posting extends Model implements HasMedia
{
    use HasFactory, LogsActivity, InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'is_current' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->useLogName('postings')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return "Posting {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('posting_orders')
            ->singleFile()
            ->accepts9MimeTypes(['image/jpeg', 'image/png', 'image/gif', 'application/pdf']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function district()
    {
        return $this->hasOneThrough(
            District::class,
            Office::class,
            'id', // Foreign key on the offices table
            'id', // Foreign key on the districts table
            'office_id', // Local key on the postings table
            'district_id' // Local key on the offices table
        );
    }

    public function hasDistrict()
    {
        return $this->office && $this->office->district_id !== null;
    }

    // Check if posting is in a specific district
    public function isInDistrict($districtId)
    {
        return $this->office && $this->office->district_id == $districtId;
    }

    // Get all users posted to the same district
    public function districtColleagues()
    {
        if (!$this->office || !$this->office->district_id) {
            return collect();
        }
        
        return Posting::where('id', '!=', $this->id)
            ->where('is_current', true)
            ->whereHas('office', function($query) {
                $query->where('district_id', $this->office->district_id);
            })
            ->with('user')
            ->get();
    }

    // Scope to find postings in a district
    public function scopeInDistrict($query, $districtId)
    {
        return $query->whereHas('office', function($q) use ($districtId) {
            $q->where('district_id', $districtId);
        });
    }

    // Get all districts this posting has influence over (direct + hierarchical)
    public function getAllDistricts()
    {
        $districts = collect();
        
        // Check if this posting's office has a direct district
        if ($this->office && $this->office->district_id) {
            $directDistrict = District::find($this->office->district_id);
            if ($directDistrict) {
                $districts->push($directDistrict);
            }
        }
        
        // Get subordinate districts
        if ($this->office) {
            // Get all descendant offices of this posting's office
            $subordinateOffices = $this->office->getAllDescendants();
            
            // Collect districts from all subordinate offices
            foreach ($subordinateOffices as $subordinateOffice) {
                if ($subordinateOffice->district_id) {
                    $district = District::find($subordinateOffice->district_id);
                    if ($district) {
                        $districts->push($district);
                    }
                }
            }
        }
        
        return $districts->unique('id');
    }

    // Get all users in the districts this posting has influence over
    public function getDistrictUsers()
    {
        $districts = $this->getAllDistricts();
        
        if ($districts->isEmpty()) {
            return collect();
        }
        
        $districtIds = $districts->pluck('id')->toArray();
        
        return User::whereHas('currentPosting', function($query) use ($districtIds) {
            $query->whereHas('office', function($q) use ($districtIds) {
                $q->whereIn('district_id', $districtIds);
            });
        })->get();
    }

    // Check if posting has influence over a specific district
    public function hasInfluenceOverDistrict($districtId)
    {
        return $this->getAllDistricts()->contains('id', $districtId);
    }

    // Scope to find all postings with influence over a certain district
    public function scopeWithInfluenceOverDistrict($query, $districtId)
    {
        // First get all offices that have this district directly
        $directOfficeIds = Office::where('district_id', $districtId)->pluck('id')->toArray();
        
        // Then get all parent offices that could have hierarchical influence
        $parentOfficeIds = collect();
        $directOffices = Office::whereIn('id', $directOfficeIds)->get();
        
        foreach ($directOffices as $office) {
            $ancestors = $office->getAncestors();
            $parentOfficeIds = $parentOfficeIds->merge($ancestors->pluck('id'));
        }
        
        // Combine both direct and hierarchical office IDs
        $allRelevantOfficeIds = array_merge($directOfficeIds, $parentOfficeIds->toArray());
        
        // Find postings in any of these offices
        return $query->whereIn('office_id', $allRelevantOfficeIds);
    }

    // Get all subordinate postings in the same or child districts
    public function getDistrictSubordinates()
    {
        if (!$this->office) {
            return collect();
        }
        
        // Get all descendant offices
        $childOffices = $this->office->getAllDescendants();
        
        if ($childOffices->isEmpty()) {
            return collect();
        }
        
        $childOfficeIds = $childOffices->pluck('id')->toArray();
        
        // Find all postings in descendant offices
        return Posting::where('id', '!=', $this->id)
            ->where('is_current', true)
            ->whereIn('office_id', $childOfficeIds)
            ->with(['user', 'office', 'designation'])
            ->get();
    }

    public function endPosting($endDate)
    {
        $this->update([
            'end_date' => $endDate,
            'is_current' => false
        ]);
    }
    
    public function isValidAgainstSanctionedPost()
    {
        $sanctionedPost = SanctionedPost::where('office_id', $this->office_id)
            ->where('designation_id', $this->designation_id)
            ->first();
            
        if (!$sanctionedPost) {
            return false;
        }
        
        $currentPostingsCount = Posting::where('office_id', $this->office_id)
            ->where('designation_id', $this->designation_id)
            ->where('is_current', true)
            ->count();
            
        return $currentPostingsCount < $sanctionedPost->total_positions;
    }
}
