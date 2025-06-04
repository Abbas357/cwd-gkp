<?php

namespace App\Models;

use App\Traits\HandleJsonAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsultantProject extends Model
{
    use HasFactory, HandleJsonAttributes;

    protected $guarded = [];
    
    protected $table = 'consultant_projects';

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    // HR management methods using the trait
    public function getHrIds()
    {
        return $this->getJsonAttribute('hr');
    }

    public function setHrIds($hrIds)
    {
        $this->setJsonAttribute('hr', $hrIds);
    }

    public function addHumanResource($hrId)
    {
        $this->addToJsonAttribute('hr', $hrId);
        $this->save();
    }

    public function removeHumanResource($hrId)
    {
        $this->removeFromJsonAttribute('hr', $hrId);
        $this->save();
    }

    public function hasHumanResource($hrId)
    {
        return $this->hasInJsonAttribute('hr', $hrId);
    }

    public function getAssignedHrCountAttribute()
    {
        return $this->countJsonAttribute('hr');
    }

    // Get assigned human resources objects
    public function getAssignedHumanResourcesAttribute()
    {
        $hrIds = $this->getHrIds();
        
        if (empty($hrIds)) {
            return collect();
        }

        return ConsultantHumanResource::whereIn('id', $hrIds)
            ->where('consultant_id', $this->consultant_id)
            ->get();
    }

    // Get available HR for assignment (optimized query)
    public function getAvailableHumanResourcesAttribute()
    {
        // Get all active projects for this consultant (excluding current project)
        $activeProjectsWithHr = self::where('consultant_id', $this->consultant_id)
            ->where('status', 'active')
            ->where('id', '!=', $this->id)
            ->whereNotNull('hr')
            ->pluck('hr');

        // Extract all assigned HR IDs
        $assignedHrIds = [];
        foreach ($activeProjectsWithHr as $hrJson) {
            $hrIds = json_decode($hrJson, true);
            if (is_array($hrIds)) {
                $assignedHrIds = array_merge($assignedHrIds, $hrIds);
            }
        }
        $assignedHrIds = array_unique($assignedHrIds);

        return $this->consultant->humanResources()
            ->where('status', 'approved')
            ->whereNotIn('id', $assignedHrIds)
            ->get();
    }

    // Scopes for easier querying
    public function scopeWithHumanResource($query, $hrId)
    {
        return $query->whereJsonAttributeContains('hr', $hrId);
    }

    public function scopeWithoutHumanResource($query, $hrId)
    {
        return $query->whereJsonAttributeDoesntContain('hr', $hrId);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForConsultant($query, $consultantId)
    {
        return $query->where('consultant_id', $consultantId);
    }

    public function district() {
        return $this->belongsTo(District::class);
    }
}
