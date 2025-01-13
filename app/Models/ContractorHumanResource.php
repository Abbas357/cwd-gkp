<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ContractorHumanResource extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'contractor_human_resources';

    protected $fillable = [
        'name',
        'cnic_number',
        'pec_number',
        'designation',
        'start_date',
        'end_date',
        'salary',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('contractor_hr_resumes')->singleFile();
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
