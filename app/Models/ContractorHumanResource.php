<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractorHumanResource extends Model
{
    protected $table = 'contractor_human_resources';

    protected $fillable = [
        'name',
        'cnic',
        'pec_number',
        'designation',
        'salary',
        'joining_date',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('contractor_human_resources')->singleFile();
    }
}
