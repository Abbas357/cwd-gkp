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
        
        $firstType = $galleryTypes->first();
        $firstTypeGalleries = [];
        
        if ($firstType) {
            $firstTypeGalleries = Gallery::where('type', $firstType)
                ->orderBy('published_at', 'desc')
                ->with('media')
                ->get();
        }
        
        $galleriesByType = collect([$firstType => $firstTypeGalleries]);
        
        return view('site.gallery.index', compact('galleryTypes', 'galleriesByType', 'firstType'));
    }
    
    public function getGalleriesByType(Request $request)
    {
        $type = $request->type;
        
        $galleries = Gallery::where('type', $type)
            ->orderBy('published_at', 'desc')
            ->with('media')
            ->get();
            
        return response()->json([
            'success' => true,
            'galleries' => $galleries,
            'html' => view('site.gallery.partials.gallery-items', compact('galleries', 'type'))->render()
        ]);
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
            'user' => $gallery->user->currentPosting->designation->name,
            'views_count' => $gallery->views_count,
            'published_by' => $gallery->publishBy->designation,
            'published_at' => $gallery->published_at?->format('M d, Y'),
            'images' => $gallery->getMedia('gallery')->map(function ($media) {
                return $media->getUrl();
            })->toArray() ?: [asset('admin/images/no-image.jpg')],
            'comments' => $gallery->comments()->whereNull('parent_id')->with('replies')->get(),
        ];

        $this->incrementViews($gallery);

        return view('site.gallery.show', compact('galleryData'));
    }
}
