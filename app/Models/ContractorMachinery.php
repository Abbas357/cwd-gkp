<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractorMachinery extends Model
{
    protected $table = 'contractor_machinery';

    protected $fillable = [
        'name',
        'number',
        'model',
        'registration'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('contractor_machinery')->singleFile();
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
