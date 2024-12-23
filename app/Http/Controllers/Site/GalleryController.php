<?php

namespace App\Http\Controllers\Site;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function index()
    {
        $galleryTypes = Gallery::select('type')->distinct()->pluck('type');

        $galleriesByType = $galleryTypes->mapWithKeys(function ($type) {
            $galleries = Gallery::where('type', $type)
                ->orderBy('published_at', 'desc')
                ->with('media')
                ->limit(5)
                ->get();

            return [$type => $galleries];
        });

        return view('site.gallery.index', compact('galleriesByType'));
    }

    public function showGalleryDetail($slug)
    {
        $gallery = Gallery::where('slug', $slug)
            ->with(['media', 'user'])
            ->firstOrFail();

        $galleryData = [
            'id' => $gallery->id,
            'title' => $gallery->title,
            'slug' => $gallery->slug,
            'description' => $gallery->description,
            'type' => ucfirst(str_replace('_', ' ', $gallery->type)) ?? 'General',
            'user' => $gallery->user->designation,
            'views_count' => $gallery->views_count,
            'published_by' => $gallery->publishBy->designation,
            'published_at' => $gallery->published_at?->format('M d, Y'),
            'images' => $gallery->getMedia('gallery')->map(function ($media) {
                return $media->getUrl();
            })->toArray() ?: [asset('admin/images/no-image.jpg')],
        ];

        $gallery->increment('views_count');

        return view('site.gallery.show', compact('galleryData'));
    }
}
