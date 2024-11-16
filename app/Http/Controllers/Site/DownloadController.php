<?php

namespace App\Http\Controllers\Site;

use App\Models\Download;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    public function index()
    {
        $latestCategorySubquery = Download::select('category', 'published_at')
            ->orderBy('published_at', 'desc')
            ->limit(100)
            ->get()
            ->unique('category')
            ->pluck('category');

        $downloadsByCategory = $latestCategorySubquery->mapWithKeys(function ($category) {
            $downloads = Download::where('category', $category)
                ->orderBy('published_at', 'desc')
                ->get();
            return [$category => $downloads];
        });

        return view('site.downloads.index', compact('downloadsByCategory'));
    }
}
