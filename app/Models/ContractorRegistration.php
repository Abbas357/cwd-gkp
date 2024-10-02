<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\Loggable;

class ContractorRegistration extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Loggable;

    protected $guarded = [];

    public function getLogAction($field, $newValue)
    {
        if ($field === 'status') {
            return $newValue === 4 ? 'approval' : 'deferred';
        }
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cnic_front_attachments')->singleFile();
        $this->addMediaCollection('cnic_back_attachments')->singleFile();
        $this->addMediaCollection('fbr_attachments')->singleFile();
        $this->addMediaCollection('kpra_attachments')->singleFile();
        $this->addMediaCollection('pec_attachments')->singleFile();
        $this->addMediaCollection('form_h_attachments')->singleFile();
        $this->addMediaCollection('pre_enlistment_attachments')->singleFile();
    }
}
