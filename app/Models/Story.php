<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Story extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('stories')
        ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);
    }
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit(Fit::Crop, 100, 100)->nonQueued();
    }

    public function user() {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function publishBy() {
        return $this->belongsTo(User::class, 'published_by');
    }

}
