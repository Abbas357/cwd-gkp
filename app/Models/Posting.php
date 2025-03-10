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

    public function districts()
    {
        return $this->belongsToMany(District::class, 'district_posting');
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
