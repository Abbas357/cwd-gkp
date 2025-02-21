<?php

namespace App\Models;

use App\Models\User;
use App\Models\Posting;
use App\Models\DevelopmentProject;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory, LogsActivity;
    
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'district_user', 'district_id', 'user_id');
    }

    public function developmentProjects()
    {
        return $this->hasMany(DevelopmentProject::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->useLogName('districts')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return "District {$eventName}";
            });
    }

    public function postings()
    {
        return $this->belongsToMany(Posting::class, 'district_posting');
    }

    public function currentOfficers()
    {
        return $this->hasManyThrough(
            User::class,
            Posting::class,
            'id',
            'id',
            'posting_id',
            'user_id'
        )->whereHas('postings', function ($query) {
            $query->where('is_current', true);
        });
    }

    public function getDistrictChainOfCommand($districtId) 
    {
        // Find the current posting assigned to this district
        $directPosting = Posting::where('is_current', true)
            ->whereHas('districts', function($query) use ($districtId) {
                $query->where('districts.id', $districtId);
            })
            ->first();
        
        if (!$directPosting) {
            return collect();
        }
        
        $chain = collect([$directPosting]);
        
        // Walk up the reporting chain
        $currentPosting = $directPosting;
        while ($relationship = $currentPosting->asSubordinate()->where('is_current', true)->first()) {
            $supervisorPosting = $relationship->supervisorPosting;
            if ($supervisorPosting) {
                $chain->push($supervisorPosting);
                $currentPosting = $supervisorPosting;
            } else {
                break;
            }
        }
        
        return $chain->map(function($posting) {
            return [
                'user' => $posting->user,
                'designation' => $posting->designation->name,
                'office' => $posting->office->name
            ];
        });
    }
}
