<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Slider extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('sliders')
            ->singleFile()
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/gif'
            ]);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('small')->width(400)->nonQueued();
        $this->addMediaConversion('medium')->width(800)->nonQueued();
        $this->addMediaConversion('large')->width(1200)->nonQueued();

        // <img 
        //     src="{{ $user->getFirstMediaUrl('images', 'thumb') }}" 
        //     srcset="
        //         {{ $user->getFirstMediaUrl('images', 'small') }} 400w, 
        //         {{ $user->getFirstMediaUrl('images', 'medium') }} 800w, 
        //         {{ $user->getFirstMediaUrl('images', 'large') }} 1200w" 
        //     sizes="(max-width: 600px) 200px, (max-width: 1000px) 400px, (max-width: 1400px) 800px, (max-width: 1800px) 1200px, 1200px"
        //     alt="User image">
    }

    public function user() {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function publishBy() {
        return $this->belongsTo(User::class, 'published_by');
    }

}
