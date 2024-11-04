<?php

namespace App\Http\Controllers\Site;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $newsResults = News::where('title', 'LIKE', "%{$query}%")
            ->orWhere('summary', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->get()
            ->map(function ($news) {
                $mediaItem = $news->getFirstMedia('news_attachments');

                if ($mediaItem && $mediaItem->mime_type === 'application/pdf') {
                    $news->image_url = asset('site/images/pdf-placeholder.png');
                } elseif ($mediaItem) {
                    $news->image_url = $mediaItem->getUrl();
                } else {
                    $news->image_url = asset('site/images/file-placeholder.png');
                }

                return $news;
            });

        if ($newsResults->isEmpty()) {
            $html = '<ul class="cw-search-results"><li class="cw-search-item">No results found.</li></ul>';
        } else {
            $html = view('layouts.site.partials.search', compact('newsResults'))->render();
        }

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }
}
