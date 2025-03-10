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

    public function users()
    {
        return $this->belongsToMany(User::class, 'district_user', 'district_id', 'user_id');
    }

    // Relationship to postings
    public function postings()
    {
        return $this->belongsToMany(Posting::class, 'district_posting');
    }

    public function office()
    {
        return $this->hasOne(Office::class);
    }

    // Get all offices responsible for this district (direct and ancestors)
    public function responsibleOffices()
    {
        $districtOffice = $this->office;
        if (!$districtOffice) {
            return collect();
        }
        
        // Include the direct office and all its ancestors
        $offices = collect([$districtOffice]);
        $offices = $offices->merge($districtOffice->getAncestors());
        
        return $offices;
    }

    // Get all users currently posted to offices responsible for this district
    public function currentOfficers()
    {
        $officeIds = $this->responsibleOffices()->pluck('id');
        
        return User::whereHas('currentPosting', function($query) use ($officeIds) {
            $query->whereIn('office_id', $officeIds)
                  ->where('is_current', true);
        })->get();
    }

    // Get the direct officer responsible for this district (officer in the district office)
    public function directOfficer()
    {
        $districtOffice = $this->office;
        if (!$districtOffice) {
            return null;
        }
        
        return User::whereHas('currentPosting', function($query) use ($districtOffice) {
            $query->where('office_id', $districtOffice->id)
                  ->where('is_current', true);
        })->first();
    }

    // Get the chain of command for this district
    public function getDistrictChainOfCommand() 
    {
        $chain = collect();
        $responsibleOffices = $this->responsibleOffices();
        
        foreach ($responsibleOffices as $office) {
            $headUser = User::whereHas('currentPosting', function($query) use ($office) {
                $query->where('office_id', $office->id)
                      ->where('is_current', true);
            })
            ->with(['currentDesignation', 'currentOffice'])
            ->first();
            
            if ($headUser) {
                $chain->push([
                    'user' => $headUser,
                    'designation' => $headUser->currentDesignation ? $headUser->currentDesignation->name : null,
                    'office' => $office->name
                ]);
            }
        }
        
        return $chain;
    }
}
