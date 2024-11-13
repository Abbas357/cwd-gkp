<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

use App\Models\News;
use App\Models\Page;
use App\Models\User;
use App\Models\Slider;
use App\Models\Gallery;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function site()
    {
        $sliders = Cache::remember('sliders', 1440, function () {
            return Slider::select('id', 'title', 'slug', 'summary')
                ->with('media')
                ->limit(5)
                ->get()
                ->map(function ($slider) {
                    return [
                        'id' => $slider->id,
                        'title' => $slider->title,
                        'slug' => $slider->slug,
                        'summary' => $slider->summary,
                        'image' => [
                            'medium' => $slider->getFirstMediaUrl('sliders', 'medium'),
                            'large' => $slider->getFirstMediaUrl('sliders', 'large'),
                            'original' => $slider->getFirstMediaUrl('sliders')
                        ]
                    ];
                });
        });

        return view('site.home.index', [
            'title' => 'HomePage',
            'sliders' => $sliders
        ]);
    }

    public function messagePartial()
    {
        $data = Cache::remember('message_partial', 1440, function () {
            $minister = User::select('id', 'name', 'title', 'designation', 'message')
                ->where('designation', 'minister')
                ->with('media')
                ->latest('created_at')
                ->first();

            $secretary = User::select('id', 'name', 'title', 'designation', 'message')
                ->where('designation', 'secretary')
                ->with('media')
                ->latest('created_at')
                ->first();

            $ministerData = $minister ? [
                'name' => $minister->name,
                'title' => $minister->title,
                'designation' => $minister->designation,
                'message' => $minister->message,
                'image' => $minister->getFirstMediaUrl('profile_pictures', 'small')
            ] : null;

            $secretaryData = $secretary ? [
                'name' => $secretary->name,
                'title' => $secretary->title,
                'designation' => $secretary->designation,
                'message' => $secretary->message,
                'image' => $secretary->getFirstMediaUrl('profile_pictures', 'small')
            ] : null;

            return compact('ministerData', 'secretaryData');
        });

        return view('site.home.partials.message', $data);
    }

    public function aboutPartial()
    {
        $aboutData = Cache::remember('about_partial', 43200, function () {
            $about = Page::where('page_type', 'about_us')
                ->with('media')
                ->latest()
                ->first();

            return [
                'id' => $about->id ?? null,
                'title' => $about->title ?? 'About Us',
                'content' => $about->content ?? '',
                'image' => $about->getFirstMediaUrl('page_attachments')
                    ?: asset('admin/images/no-image.jpg'),
            ];
        });

        return view('site.home.partials.about', compact('aboutData'));
    }

    public function galleryPartial()
    {
        $latestTypeSubquery = Gallery::select('type', 'published_at')
            ->orderBy('published_at', 'desc')
            ->limit(100)
            ->get()
            ->unique('type')
            ->take(5)
            ->pluck('type');

        $galleriesByType = $latestTypeSubquery->mapWithKeys(function ($type) {
            $galleries = Gallery::with('media')
                ->where('type', $type)
                ->orderBy('published_at', 'desc')
                ->limit(5)
                ->get();
            return [$type => $galleries];
        });

        return view('site.home.partials.gallery', compact('galleriesByType'));
    }

    public function blogsPartial()
    {
        $allNews = News::where('status', 'published')
            ->with(['media', 'user'])
            ->latest('published_at')
            ->limit(3)
            ->get()
            ->map(function ($news) {
                $media = $news->getFirstMedia('news_attachments');
                $fileType = $media ? $media->mime_type : null;

                return [
                    'id' => $news->id,
                    'title' => $news->title,
                    'slug' => $news->slug,
                    'summary' => $news->summary ?? 'No summary available.',
                    'content' => $news->content ?? 'No content available.',
                    'category' => $news->category ?? 'General',
                    'author' => $news->user->designation,
                    'created' => $news->created_at->diffForHumans(),
                    'published_at' => $news->published_at->format('M d, Y'),
                    'image' => $media ? $media->getUrl() : asset('admin/images/no-image.jpg'),
                    'file_type' => $fileType,
                ];
            });

        return view('site.home.partials.blogs', compact('allNews'));
    }


    public function teamPartial()
    {
        $users = Cache::remember('team_partial', 43200, function () {
            return User::select('id', 'name', 'title', 'designation', 'bps')
                ->whereIn('bps', ['BPS-19', 'BPS-20'])
                ->with('media')
                ->latest('created_at')
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'title' => $user->title ?? 'N/A',
                        'designation' => $user->designation ?? 'N/A',
                        'facebook' => $user->facebook ?? '#',
                        'twitter' => $user->twitter ?? '#',
                        'whatsapp' => $user->whatsapp ?? '#',
                        'mobile_number' => $user->mobile_number ?? '#',
                        'landline_number' => $user->landline_number ?? '#',
                        'image' => $user->getFirstMediaUrl('profile_pictures', 'small')
                            ?: asset('admin/images/no-profile.png')
                    ];
                });
        });

        return view('site.home.partials.team', [
            'users' => $users
        ]);
    }

    public function contactPartial()
    {
        return view('site.home.partials.contact');
    }
}
