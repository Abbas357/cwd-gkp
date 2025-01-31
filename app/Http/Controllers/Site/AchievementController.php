<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Achievement;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::latest()->paginate(10);
        return view('site.achievements.index', compact('achievements'));
    }

    public function showAchievement($slug)
    {
        $achievement = Achievement::where('slug', $slug)->firstOrFail();
        
        $mediaUrls = $achievement->getMedia('achievement_files')->map(function ($media) {
            return $media->getUrl();
        });

        $achievementData = [
            'id' => $achievement->id,
            'title' => $achievement->title,
            'slug' => $achievement->slug,
            'content' => $achievement->content,
            'location' => $achievement->location,
            'start_date' => $achievement->start_date->format('M d, Y'),
            'end_date' => $achievement->end_date->format('M d, Y'),
            'published_by' => $achievement->publishBy->designation,
            'published_at' => $achievement->published_at->format('M d, Y'),
            'views_count' => $achievement->views_count,
            'attachments' => $mediaUrls,
        ];

        $this->incrementViews($achievement);

        return view('site.achievements.show', compact('achievementData'));
    }
}
