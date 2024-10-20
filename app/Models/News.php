<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    
    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('news_attachments')
        ->singleFile()
        ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'application/pdf']);
    }

    public function user() {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function publishBy() {
        return $this->belongsTo(User::class, 'published_by');
    }

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }
}
