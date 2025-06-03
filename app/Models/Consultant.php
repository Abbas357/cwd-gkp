<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $casts = [
        'status_updated_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function humanResources()
    {
        return $this->hasMany(ConsultantHumanResource::class);
    }

    public function projects()
    {
        return $this->hasMany(ConsultantProject::class);
    }

    public function activeHumanResources()
    {
        return $this->humanResources()->where('status', 'approved');
    }

    public function activeProjects()
    {
        return $this->projects()->where('status', 'active');
    }

    public function district() {
        return $this->belongsTo(District::class);
    }
}
