<?php

namespace App\Http\Controllers\Site;

use App\Models\Download;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    public function index()
    {
        $categories = Download::select('category')
            ->distinct()
            ->orderBy('category', 'asc')
            ->pluck('category');

        $firstCategory = $categories->first();
        $firstCategoryDownloads = collect();

        if ($firstCategory) {
            $firstCategoryDownloads = Download::where('category', $firstCategory)
                ->orderBy('published_at', 'desc')
                ->get();
        }

        return view('site.downloads.index', compact('categories', 'firstCategory', 'firstCategoryDownloads'));
    }

    public function fetchCategory(Request $request)
    {
        $category = $request->input('category');

        if (!$category) {
            return response()->json([
                'downloads' => '<p class="text-center text-danger">Invalid category.</p>',
            ]);
        }

        $downloads = Download::where('category', $category)
            ->orderBy('published_at', 'desc')
            ->get();

        return response()->json([
            'downloads' => view('site.downloads.partials.downloads_table', [
                'downloads' => $downloads,
                'category' => $category,
            ])->render(),
        ]);
    }
}
