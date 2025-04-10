<?php

namespace App\Models;

use App\Models\User;
use App\Models\Office;
use App\Models\District;
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
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'application/pdf']);
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

    public function damages()
    {
        return $this->hasMany(Damage::class);
    }

    public function district()
    {
        return $this->hasOneThrough(
            District::class,
            Office::class,
            'id',
            'id',
            'office_id',
            'district_id'
        );
    }

    public function hasDistrict()
    {
        return $this->office && $this->office->district_id !== null;
    }

    public function isInDistrict($districtId)
    {
        return $this->office && $this->office->district_id == $districtId;
    }

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

    public function scopeInDistrict($query, $districtId)
    {
        return $query->whereHas('office', function($q) use ($districtId) {
            $q->where('district_id', $districtId);
        });
    }

    public function getAllDistricts()
    {
        $districts = collect();
        
        if ($this->office && $this->office->district_id) {
            $directDistrict = District::find($this->office->district_id);
            if ($directDistrict) {
                $districts->push($directDistrict);
            }
        }
        
        if ($this->office) {
            $subordinateOffices = $this->office->getAllDescendants();
            
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

    public function hasInfluenceOverDistrict($districtId)
    {
        return $this->getAllDistricts()->contains('id', $districtId);
    }

    public function scopeWithInfluenceOverDistrict($query, $districtId)
    {
        $directOfficeIds = Office::where('district_id', $districtId)->pluck('id')->toArray();
        
        $parentOfficeIds = collect();
        $directOffices = Office::whereIn('id', $directOfficeIds)->get();
        
        foreach ($directOffices as $office) {
            $ancestors = $office->getAncestors();
            $parentOfficeIds = $parentOfficeIds->merge($ancestors->pluck('id'));
        }
        
        $allRelevantOfficeIds = array_merge($directOfficeIds, $parentOfficeIds->toArray());
        
        return $query->whereIn('office_id', $allRelevantOfficeIds);
    }

    public function getDistrictSubordinates()
    {
        if (!$this->office) {
            return collect();
        }
        
        $childOffices = $this->office->getAllDescendants();
        
        if ($childOffices->isEmpty()) {
            return collect();
        }
        
        $childOfficeIds = $childOffices->pluck('id')->toArray();
        
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
