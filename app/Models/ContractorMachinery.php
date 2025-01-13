<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ContractorMachinery extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    protected $table = 'contractor_machinery';

    protected $fillable = [
        'name',
        'number',
        'model',
        'registration',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('contractor_machinery_docs');
        $this->addMediaCollection('contractor_machinery_pics');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
