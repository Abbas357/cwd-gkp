<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultantProject extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $table = 'consultant_projects';

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relationships
    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    public function assignedHumanResources()
    {
        return $this->belongsToMany(
            ConsultantHumanResource::class,
            'consultant_projects_hr',
            'project_id',
            'employee_id'
        )->withPivot([
            'start_date',
            'end_date',
            'status',
            'remarks'
        ])->withTimestamps();
    }

    public function activeAssignedHumanResources()
    {
        return $this->assignedHumanResources()->wherePivot('status', 'active');
    }

    // Get available HR for assignment (not currently assigned to other projects)
    public function getAvailableHumanResources()
    {
        return $this->consultant->humanResources()
            ->where('status', 'approved')
            ->whereDoesntHave('projectAssignments', function ($query) {
                $query->where('status', 'active');
            });
    }
}
