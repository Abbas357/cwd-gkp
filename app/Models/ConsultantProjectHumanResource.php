<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultantProjectHumanResource extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $table = 'consultant_project_human_resources';

    protected $casts = [
        'assignment_start_date' => 'date',
        'assignment_end_date' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(ConsultantProject::class, 'consultant_project_id');
    }

    public function humanResource()
    {
        return $this->belongsTo(ConsultantHumanResource::class, 'consultant_human_resource_id');
    }
}
