<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Story extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('stories')
        ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);
    }

}
