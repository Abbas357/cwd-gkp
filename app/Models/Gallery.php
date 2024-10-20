<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('galleries')
            ->singleFile()
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/gif'
            ]);

        $this->addMediaCollection('cover_images')
            ->singleFile()
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/gif'
            ]);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function publishBy() {
        return $this->belongsTo(User::class, 'published_by');
    }
}
