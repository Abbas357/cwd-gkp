<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\Loggable;

class EStandardization extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Loggable;
    
    protected $guarded = [];

    public function getLogAction($field, $newValue)
    {
        if ($field === 'status') {
            return $newValue === 1 ? 'approval' : 'rejection';
        }
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('secp_certificates')->singleFile();
        $this->addMediaCollection('iso_certificates')->singleFile();
        $this->addMediaCollection('commerse_memberships')->singleFile();
        $this->addMediaCollection('pec_certificates')->singleFile();
        $this->addMediaCollection('annual_tax_returns')->singleFile();
        $this->addMediaCollection('audited_financials')->singleFile();
        $this->addMediaCollection('organization_registrations')->singleFile();
        $this->addMediaCollection('performance_certificate')->singleFile();
    }
}
