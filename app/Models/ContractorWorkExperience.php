<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ContractorWorkExperience extends Model implements HasMedia
{
    use InteractsWithMedia;

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
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
    
}
