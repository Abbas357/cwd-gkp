<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Page;
use App\Models\User;
use App\Models\Slider;
use App\Models\Gallery;
use Illuminate\Support\Facades\Cache;

class HomePageController extends Controller
{
    public function dashboard()
    {
        return view('admin.home.index');
    }

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
                            'small' => $slider->getFirstMediaUrl('sliders', 'small'),
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

    public function showSlider($slug)
    {
        $slider = Slider::where('slug', $slug)->with(['media'])->firstOrFail();

        $sliderData = [
            'id' => $slider->id,
            'title' => $slider->title,
            'description' => $slider->description,
            'published_at' => $slider->published_at,
            'published_by' => $slider->publishedBy->designation,
            'image' => [
                'small' => $slider->getFirstMediaUrl('sliders', 'small'),
                'medium' => $slider->getFirstMediaUrl('sliders', 'medium'),
                'large' => $slider->getFirstMediaUrl('sliders', 'large'),
                'original' => $slider->getFirstMediaUrl('sliders')
            ]
        ];

        return view('site.sliders.show', compact('sliderData'));
    }

    public function messagePartial()
    {
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

        return view('site.home.partials.message', compact('ministerData', 'secretaryData'));
    }

    public function showPositions($designation)
    {
        $users = User::where('designation', $designation)
            ->with(['media' => function ($query) {
                $query->whereIn('collection_name', ['profile_pictures', 'posting_orders', 'exit_orders']);
            }])
            ->get();

        $userData = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'title' => $user->title,
                'posting_date' => $user->posting_date ? $user->posting_date->format('j, F Y') : 'N/A',
                'exit_date' => $user->exit_date ? $user->exit_date->format('j, F Y') : 'N/A',
                'profile_pictures' => $user->getFirstMediaUrl('profile_pictures'),
            ];
        });

        return view('site.users.list', compact('userData', 'designation'));
    }

    public function getUserDetails($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        $userData = [
            'id' => $user->id,
            'name' => $user->name ?? 'N/A',
            'cnic' => $user->cnic ?? 'N/A',
            'email' => $user->email ?? 'N/A',
            'mobile_number' => $user->mobile_number ?? 'N/A',
            'landline_number' => $user->landline_number ?? 'N/A',
            'whatsapp' => $user->whatsapp ?? 'N/A',
            'facebook' => $user->facebook ?? 'N/A',
            'twitter' => $user->twitter ?? 'N/A',
            'designation' => $user->designation ?? 'N/A',
            'title' => $user->title ?? 'N/A',
            'posting_type' => $user->posting_type ?? 'N/A',
            'posting_date' => $user->posting_date ? $user->posting_date->format('j, F Y') : 'N/A',
            'exit_type' => $user->exit_type ?? 'N/A',
            'exit_date' => $user->exit_date ? $user->exit_date->format('j, F Y') : 'N/A',
            'media' => [
                'profile_pictures' => $user->getFirstMediaUrl('profile_pictures', 'small')
                    ?: asset('admin/images/no-profile.png'),
                'posting_orders' => $user->getFirstMediaUrl('posting_orders'),
                'exit_orders' => $user->getFirstMediaUrl('exit_orders'),
            ],
        ];

        $html = view('site.users.partials.detail', ['user' => $userData])->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function aboutPartial()
    {
        $about = Page::where('page_type', 'about_us')
            ->with('media')
            ->latest()
            ->first();

        $aboutData = [
            'id' => $about->id ?? null,
            'title' => $about->title ?? 'About Us',
            'content' => $about->content ?? '',
            'image' => $about->getFirstMediaUrl('page_attachments')
                ?: asset('admin/images/no-image.jpg'),
        ];

        return view('site.home.partials.about', compact('aboutData'));
    }

    public function galleryPartial()
    {
        $latestTypeSubquery = Gallery::select('type', 'published_at')
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->limit(100)
            ->get()
            ->unique('type') 
            ->take(5)
            ->pluck('type');

        $galleriesByType = $latestTypeSubquery->mapWithKeys(function ($type) {
            $galleries = Gallery::with('media')
                ->where('type', $type)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->orderBy('published_at', 'desc')
                ->limit(5)
                ->get();
            return [$type => $galleries];
        });

        return view('site.home.partials.gallery', compact('galleriesByType'));
    }

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


    public function blogsPartial()
    {
        $allNews = News::where('status', 'published')
            ->with(['media', 'user'])
            ->latest('published_at')
            ->limit(3)
            ->get()
            ->map(function ($news) {
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
                    'image' => $news->getFirstMediaUrl('news_attachments', 'small')
                        ?: asset('admin/images/no-image.jpg'),
                ];
            });
        return view('site.home.partials.blogs', compact('allNews'));
    }

    public function showNews($slug)
    {
        $news = News::where('slug', $slug)->with(['media'])->firstOrFail();

        $newsData = [
            'id' => $news->id,
            'title' => $news->title,
            'slug' => $news->slug,
            'summary' => $news->summary ?? 'No summary available.',
            'content' => $news->content ?? 'No content available.',
            'category' => $news->category ?? 'General',
            'author' => $news->user->designation,
            'published_by' => $news->publishBy->designation,
            'published_at' => $news->published_at->format('M d, Y'),
            'image' => $news->getFirstMediaUrl('news_attachments')
                ?: asset('admin/images/no-image.jpg'),
        ];

        return view('site.news.show', compact('newsData'));
    }

    public function teamPartial()
    {
        $users = User::select('id', 'name', 'title', 'designation', 'bps')
            ->where('bps', 'BPS-19')
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
                    'whatsapp' => $user->whatsapp ?? '#',
                    'image' => $user->getFirstMediaUrl('profile_pictures', 'small')
                        ?: asset('admin/images/no-profile.png')
                ];
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
