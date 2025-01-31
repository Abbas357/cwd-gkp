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

    public function showachievement($slug)
    {
        $achievement = Achievement::where('slug', $slug)->firstOrFail();
        
        $mediaUrl = $achievement->getMediaUrl('achievement_files');

        $achievementData = [
            'id' => $achievement->id,
            'title' => $achievement->title,
            'achievement_date' => \Carbon\Carbon::parse($achievement->achievement_date)->format('M d, Y'),
            'slug' => $achievement->slug,
            'views_count' => $achievement->views_count,
            'attachments' => $mediaUrl,
        ];

        $this->incrementViews($achievement);

        return view('site.achievements.show', compact('achievementData'));
    }
}
