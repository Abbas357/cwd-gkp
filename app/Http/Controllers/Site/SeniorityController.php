<?php

namespace App\Http\Controllers\Site;

use App\Models\Seniority;
use App\Http\Controllers\Controller;

class SeniorityController extends Controller
{
    public function index()
    {
        $seniorities = Seniority::latest()->paginate(10);
        return view('site.seniority.index', compact('seniorities'));
    }

    public function showSeniority($slug)
    {
        $seniority = Seniority::where('slug', $slug)->firstOrFail();
        
        $mediaUrl = $seniority->getFirstMediaUrl('seniorities');

        $seniorityData = [
            'title' => $seniority->title,
            'designation' => $seniority->designation,
            'bps' => $seniority->bps,
            'seniority_date' => \Carbon\Carbon::parse($seniority->seniority_date)->format('M d, Y'),
            'slug' => $seniority->slug,
            'status' => $seniority->status,
            'views_count' => $seniority->views_count,
            'attachment' => $mediaUrl,
        ];

        $seniority->increment('views_count');

        return view('site.seniority.show', compact('seniorityData'));
    }
}
