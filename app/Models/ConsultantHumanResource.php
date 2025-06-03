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

    public function projectAssignments()
    {
        return $this->belongsToMany(
            ConsultantProject::class,
            'consultant_projects_hr',
            'employee_id',
            'project_id'
        )->withPivot([
            'start_date',
            'end_date', 
            'status',
            'remarks'
        ])->withTimestamps();
    }

    public function activeProjectAssignments()
    {
        return $this->projectAssignments()->wherePivot('status', 'active');
    }

    // Check if HR is currently assigned to any active project
    public function isCurrentlyAssigned()
    {
        return $this->activeProjectAssignments()->exists();
    }

    // Get current active project
    public function currentProject()
    {
        return $this->activeProjectAssignments()->first();
    }
}
