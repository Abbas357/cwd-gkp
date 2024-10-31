<?php

namespace App\Http\Controllers\Site;

use App\Models\Download;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    public function index()
    {
        $latestCategorySubquery = Download::select('file_category', 'published_at')
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->limit(100)
            ->get()
            ->unique('file_category')
            ->take(5)
            ->pluck('file_category');

        $downloadsByCategory = $latestCategorySubquery->mapWithKeys(function ($category) {
            $downloads = Download::where('file_category', $category)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->orderBy('published_at', 'desc')
                ->limit(5)
                ->get();
            return [$category => $downloads];
        });

        return view('site.downloads.index', compact('downloadsByCategory'));
    }
}
