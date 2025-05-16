<?php

namespace App\Http\Controllers\Site;

use App\Models\News;

use App\Models\Page;
use App\Models\User;
use App\Models\Event;
use App\Models\Slider;
use App\Models\Tender;
use App\Models\Gallery;
use App\Models\Seniority;
use Illuminate\Http\Request;
use App\Models\SiteNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function site()
    {
        return view('site.home.index', [
            'title' => 'HomePage',
        ]);
    }

    public function sliderPartial()
    {
        $slides = Slider::select('id', 'title', 'slug', 'summary')
            ->with('media')
            ->limit(5)
            ->orderBy('order')
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
                        'original' => $slider->getFirstMediaUrl('sliders'),
                    ],
                ];
            });

        return view('site.home.partials.slider', compact('slides'));
    }

    public function messagePartial()
    {
        $data = Cache::remember('message_partial', 1440, function () {
            // Find the minister
            $minister = User::select('id', 'uuid', 'name')
                ->with(['currentPosting.designation', 'profile', 'media'])
                ->whereHas('currentPosting.designation', function($query) {
                    $query->where('name', 'Minister');
                })
                ->latest('created_at')
                ->first();
            
            // Find the secretary
            $secretary = User::select('id', 'uuid', 'name')
                ->with(['currentPosting.designation', 'profile', 'media'])
                ->whereHas('currentPosting.designation', function($query) {
                    $query->where('name', 'Secretary');
                })
                ->latest('created_at')
                ->first();
            
            // Format minister data if exists
            $ministerData = $minister ? [
                'id' => $minister->id,
                'uuid' => $minister->uuid,
                'name' => $minister->name,
                'title' => $minister->currentPosting->designation->name ?? null,
                'designation' => $minister->currentPosting->designation->name ?? null,
                'position' => $minister->currentPosting->designation->name ?? 'minister',
                'message' => $minister->profile->message ?? null,
                'image' => $minister->getFirstMediaUrl('profile_pictures', 'small') ?: asset('admin/images/default-avatar.jpg')
            ] : null;
            
            // Format secretary data if exists
            $secretaryData = $secretary ? [
                'id' => $secretary->id,
                'uuid' => $secretary->uuid,
                'name' => $secretary->name,
                'title' => $secretary->currentPosting->designation->name ?? null,
                'designation' => $secretary->currentPosting->designation->name ?? null,
                'position' => $secretary->currentPosting->designation->name ?? 'secretary',
                'message' => $secretary->profile->message ?? null,
                'image' => $secretary->getFirstMediaUrl('profile_pictures', 'small') ?: asset('admin/images/default-avatar.jpg')
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
        $latestTypes = Gallery::select('type', 'published_at')
            ->distinct('type')
            ->limit(5)
            ->pluck('type');

        $galleriesByType = $latestTypes->mapWithKeys(function ($type) {
            $galleries = Gallery::with('media')
                ->where('type', $type)
                ->orderBy('published_at', 'desc')
                ->limit(4)
                ->get();
            return [$type => $galleries];
        });

        return view('site.home.partials.gallery', compact('galleriesByType'));
    }


    public function newsPartial()
    {
        $allNews = News::where('status', 'published')
            ->with(['media', 'user'])
            ->latest('published_at')
            ->limit(5)
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
                    'author' => $news->user->currentPosting->designation->name,
                    'created' => $news->created_at->diffForHumans(),
                    'published_at' => $news->published_at->format('M d, Y'),
                    'image' => $media ? $media->getUrl() : asset('site/images/no-image.jpg'),
                    'file_type' => $fileType,
                    'views_count' => $news->views_count ?? 0,
                ];
            });

        return view('site.home.partials.news', compact('allNews'));
    }

    public function eventsPartial()
    {
        $events = Event::with(['media', 'user'])
            ->latest('published_at')
            ->limit(5)
            ->get()
            ->map(function ($event) {
                $media = $event->getFirstMediaUrl('events_pictures');
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'slug' => $event->slug,
                    'start_datetime' => $event->start_datetime,
                    'end_datetime' => $event->end_datetime,
                    'location' => $event->location,
                    'organizer' => $event->organizer,
                    'chairperson' => $event->chairperson,
                    'participants_type' => $event->participants_type,
                    'no_of_participants' => $event->no_of_participants,
                    'event_type' => $event->event_type,
                    'user' => $event->user->currentPosting->designation->name,
                    'created' => $event->created_at->diffForHumans(),
                    'published_at' => $event->published_at->format('M d, Y'),
                    'image' => $media,
                ];
            });

        return view('site.home.partials.events', compact('events'));
    }

    public function teamPartial()
    {
        $users = Cache::remember('team_partial', 43200, function () {
            return User::select('id', 'name', 'uuid')
                ->featuredOnHome()
                ->with(['currentPosting.designation', 'profile', 'media'])
                ->latest('created_at')
                ->get()
                ->map(function ($user) {
                    $profile = $user->profile ?? null;
                    
                    return [
                        'id' => $user->id,
                        'uuid' => $user->uuid,
                        'name' => $user->name,
                        'posting' => $user->currentPosting->office->name ?? 'N/A',
                        'facebook' => $profile ? $profile->facebook : '#',
                        'twitter' => $profile ? $profile->twitter : '#',
                        'whatsapp' => $profile ? $profile->whatsapp : '#',
                        'mobile_number' => $profile ? $profile->mobile_number : '#',
                        'contact_number' => $user->currentOffice->contact_number ?? '#',
                        'image' => $user->getFirstMediaUrl('profile_pictures', 'small')
                            ?: asset('admin/images/default-avatar.jpg')
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

    public function notifications(Request $request) {
        $page = $request->input('page', 1);
        $perPage = 7;
        $search = $request->input('search', '');
        $type = $request->input('type', '');
    
        $announcement = Page::where('page_type', 'Announcement')
            ->orderBy('created_at', 'desc')
            ->first();
    
        $announcementData = $announcement ? [
            'id' => $announcement->id,
            'title' => $announcement->title,
            'description' => $announcement->content,
            'image' => $announcement->getFirstMediaUrl('page_attachments') ?: asset('admin/images/no-image.jpg'),
        ] : null;
    
        $query = SiteNotification::latest();
    
        if (!empty($type)) {
            $query->where('notifiable_type', 'App\Models\\' . $type)
                  ->where('title', 'like', '%' . $search . '%');
        } elseif (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('notifiable_type', 'like', '%' . $search . '%');
        }
    
        $totalNotifications = $query->count();
    
        $notifications = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get()
            ->map(function ($notification) {
                // Define image URLs and category information for each notification type
                $categoryInfo = [
                    Tender::class => ['Tenders', 'https://placehold.co/50x50/png', route('tenders.index')],
                    Gallery::class => ['Galleries', 'https://placehold.co/50x50/png', route('gallery.index')],
                    Event::class => ['Events', 'https://placehold.co/50x50/png', route('events.index')],
                    News::class => ['News', 'https://placehold.co/50x50/png', route('news.index')],
                    Seniority::class => ['Seniorities', 'https://placehold.co/50x50/png', route('seniority.index')],
                ];
    
                // Different placeholder for each notification type
                $imageUrl = match ($notification->notifiable_type) {
                    Tender::class => asset('site/images/icons/notification-types/tender.png'),
                    Gallery::class => asset('site/images/icons/notification-types/gallery.png'),
                    Event::class => asset('site/images/icons/notification-types/event.png'),
                    News::class => asset('site/images/icons/notification-types/news.png'),
                    Seniority::class => asset('site/images/icons/notification-types/seniority.png'),
                    default => 'https://placehold.co/50x50/png?text=Notification'
                };
    
                return [
                    'id' => $notification->id,
                    'title' => strlen($notification->title) > 80 ? substr($notification->title, 0, 80) . '...' : $notification->title,
                    'url' => $notification->url,
                    'created_at' => $notification->created_at->diffForHumans(),
                    'type' => class_basename($notification->notifiable_type),
                    'info' => $categoryInfo[$notification->notifiable_type] ?? ['Notification', 'https://placehold.co/50x50/png', '#'],
                    'imageUrl' => $imageUrl,
                    'recentNotification' => $notification->created_at->gt(now()->subDay()),
                ];
            });
    
        $hasMore = ($page * $perPage) < $totalNotifications;
    
        return response()->json([
            'notifications' => $notifications,
            'nextPage' => $hasMore ? $page + 1 : null,
            'hasMore' => $hasMore,
            'announcement' => $announcementData,
        ]);
    }

    public function allNotifications(Request $request)
    {
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'type' => 'nullable|in:Tender,Event,News,Seniority,Gallery',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date|after_or_equal:date_start',
        ]);

        $types = ['Tender', 'Event', 'News', 'Seniority', 'Gallery'];

        $notifications = SiteNotification::orderByDesc('created_at')
            ->when($request->query('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                        ->orWhere('notifiable_type', 'like', "%$search%");
                });
            })
            ->when($request->query('date_start'), function ($query, $dateStart) {
                $query->whereDate('created_at', '>=', $dateStart);
            })
            ->when($request->query('date_end'), function ($query, $dateEnd) {
                $query->whereDate('created_at', '<=', $dateEnd);
            })
            ->when($request->query('type'), function ($query, $type) {
                $query->where('notifiable_type', 'App\Models\\' . $type);
            })
            ->paginate(10);

        return view('site.notifications.index', compact('notifications', 'types'));
    }
}
