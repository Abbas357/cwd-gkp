<?php

namespace App\Http\Controllers\Site;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function showGalleryDetail($slug)
    {
        $gallery = Gallery::where('slug', $slug)
            ->with(['media', 'user'])
            ->firstOrFail();

        $galleryData = [
            'id' => $gallery->id,
            'title' => $gallery->title ?? 'No title available.',
            'slug' => $gallery->slug,
            'description' => $gallery->description ?? 'No description available.',
            'type' => ucfirst(str_replace('_', ' ', $gallery->type)) ?? 'General',
            'user' => $gallery->user->designation ?? 'Unknown',
            'published_by' => $gallery->publishBy->designation ?? 'Unknown',
            'published_at' => $gallery->published_at?->format('M d, Y') ?? 'Not published',
            'images' => $gallery->getMedia('gallery')->map(function ($media) {
                return $media->getUrl();
            })->toArray() ?: [asset('admin/images/no-image.jpg')],
        ];

        return view('site.gallery.show', compact('galleryData'));
    }
}