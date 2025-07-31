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
        'is_head' => 'boolean',
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
        return $this->belongsTo(User::class)->withoutGlobalScopes();
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
            'is_current' => false,
            'is_head' => false
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

    public function scopeHeads($query)
    {
        return $query->where('is_head', true);
    }

    public function scopeCurrentHeads($query)
    {
        return $query->where('is_current', true)->where('is_head', true);
    }

    public function makeHead()
    {
        static::where('office_id', $this->office_id)
            ->where('is_current', true)
            ->where('is_head', true)
            ->update(['is_head' => false]);
        
        $this->update(['is_head' => true]);
    }

    public function removeAsHead()
    {
        $this->update(['is_head' => false]);
    }    
}

// Example: PostingController or PostingService methods

// class PostingService
// {
//     /**
//      * Create a new posting and optionally mark as head
//      */
//     public function createPosting(array $data)
//     {
//         // Check if this should be marked as head
//         $isHead = $this->shouldBeHead($data);
        
//         // If marking as head, remove current head
//         if ($isHead) {
//             Posting::where('office_id', $data['office_id'])
//                 ->where('is_current', true)
//                 ->where('is_head', true)
//                 ->update(['is_head' => false]);
//         }
        
//         return Posting::create([
//             'user_id' => $data['user_id'],
//             'office_id' => $data['office_id'],
//             'designation_id' => $data['designation_id'],
//             'type' => $data['type'] ?? 'Appointment',
//             'start_date' => $data['start_date'],
//             'is_current' => true,
//             'is_head' => $isHead,
//             'order_number' => $data['order_number'] ?? null,
//             'remarks' => $data['remarks'] ?? null,
//         ]);
//     }

//     /**
//      * Determine if a posting should be marked as head
//      */
//     protected function shouldBeHead(array $data): bool
//     {
//         // Explicit head assignment
//         if (isset($data['is_head'])) {
//             return (bool) $data['is_head'];
//         }
        
//         // Auto-determine based on designation BPS
//         $designation = Designation::find($data['designation_id']);
//         if (!$designation) {
//             return false;
//         }
        
//         // Common leadership designations (customize based on your org)
//         $leadershipDesignations = [
//             'Secretary', 'Additional Secretary', 'Deputy Secretary',
//             'Director General', 'Director', 'Deputy Director',
//             'Commissioner', 'Deputy Commissioner', 'Assistant Commissioner',
//             'Chief Engineer', 'Superintending Engineer', 'Executive Engineer',
//             // Add more as needed
//         ];
        
//         foreach ($leadershipDesignations as $leadership) {
//             if (stripos($designation->name, $leadership) !== false) {
//                 return true;
//             }
//         }
        
//         // BPS-based logic (adjust thresholds as needed)
//         if ($designation->bps >= 17) {
//             // Check if office already has a head at similar or higher BPS
//             $existingHead = Posting::where('office_id', $data['office_id'])
//                 ->where('is_current', true)
//                 ->where('is_head', true)
//                 ->whereHas('designation', function ($query) use ($designation) {
//                     $query->where('bps', '>=', $designation->bps);
//                 })
//                 ->exists();
            
//             return !$existingHead;
//         }
        
//         return false;
//     }

//     /**
//      * Transfer head status to another user in the same office
//      */
//     public function transferHeadship($fromUserId, $toUserId, $officeId)
//     {
//         DB::transaction(function () use ($fromUserId, $toUserId, $officeId) {
//             // Remove head status from current head
//             Posting::where('user_id', $fromUserId)
//                 ->where('office_id', $officeId)
//                 ->where('is_current', true)
//                 ->update(['is_head' => false]);
            
//             // Assign head status to new user
//             Posting::where('user_id', $toUserId)
//                 ->where('office_id', $officeId)
//                 ->where('is_current', true)
//                 ->update(['is_head' => true]);
//         });
//     }

//     /**
//      * Get offices without heads (for dashboard/reports)
//      */
//     public function getOfficesWithoutHeads()
//     {
//         return Office::whereDoesntHave('postings', function ($query) {
//             $query->where('is_current', true)
//                 ->where('is_head', true);
//         })
//         ->whereHas('postings', function ($query) {
//             $query->where('is_current', true);
//         })
//         ->with(['currentPostings.user', 'currentPostings.designation'])
//         ->get();
//     }
// }

// // Example usage in a controller
// class PostingController extends Controller
// {
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'user_id' => 'required|exists:users,id',
//             'office_id' => 'required|exists:offices,id',
//             'designation_id' => 'required|exists:designations,id',
//             'start_date' => 'required|date',
//             'is_head' => 'boolean',
//             // other fields...
//         ]);
        
//         $posting = app(PostingService::class)->createPosting($validated);
        
//         return redirect()->route('postings.show', $posting);
//     }
    
//     public function makeHead(Posting $posting)
//     {
//         $posting->makeHead();
        
//         return back()->with('success', 'User has been made head of the office');
//     }
// }