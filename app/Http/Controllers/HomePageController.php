<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Slider;
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
                'profile_pictures' => $user->getFirstMediaUrl('profile_pictures'),
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
        return view('site.home.partials.about');
    }

    public function galleryPartial()
    {
        return view('site.home.partials.gallery');
    }

    public function blogsPartial()
    {
        return view('site.home.partials.blogs');
    }

    public function teamPartial()
    {
        return view('site.home.partials.team');
    }

    public function contactPartial()
    {
        return view('site.home.partials.contact');
    }
}
