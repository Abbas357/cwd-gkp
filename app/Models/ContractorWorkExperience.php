<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractorWorkExperience extends Model
{
    protected $table = 'contractor_work_experiences';

    protected $fillable = [
        'adp_no',
        'name',
        'duration',
        'completion_date',
        'cost'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('contractor_work_experiences')->singleFile();
    }

    public function contractor()
    {
        return $this->belongsTo(ContractorRegistration::class, 'contractor_id');
    }
    
}
