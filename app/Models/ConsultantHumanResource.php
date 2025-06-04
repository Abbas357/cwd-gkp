<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultantHumanResource extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'consultant_human_resources';

    protected $casts = [
        'salary' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'status_updated_at' => 'datetime',
    ];

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    // Optimized method to check if HR is currently assigned
    public function isCurrentlyAssigned()
    {
        return ConsultantProject::forConsultant($this->consultant_id)
            ->active()
            ->withHumanResource($this->id)
            ->exists();
    }

    // Get current active project (optimized)
    public function currentActiveProject()
    {
        return ConsultantProject::forConsultant($this->consultant_id)
            ->active()
            ->withHumanResource($this->id)
            ->first();
    }

    // Get all projects this HR has worked on (optimized)
    public function getAllProjects()
    {
        return ConsultantProject::forConsultant($this->consultant_id)
            ->withHumanResource($this->id)
            ->get();
    }

    // Scope for approved HR
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope for available HR (not assigned to active projects)
    public function scopeAvailable($query)
    {
        return $query->approved()->whereDoesntHave('activeProjects');
    }

    // Relationship to get active projects (using raw SQL for MySQL 5.6 compatibility)
    public function activeProjects()
    {
        return $this->hasMany(ConsultantProject::class, 'consultant_id', 'consultant_id')
            ->where('status', 'active')
            ->where(function($query) {
                $query->where('hr', 'LIKE', '%"' . $this->id . '"%')
                      ->orWhere('hr', 'LIKE', '%' . $this->id . '%');
            });
    }
}
