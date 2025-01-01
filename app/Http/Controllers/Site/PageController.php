<?php

namespace App\Http\Controllers\Site;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function showPage($type)
    {
        $page = Page::where('page_type', $type)
            ->with('media')
            ->firstOrFail();

        $mediaUrls = $page->getMedia('page_attachments')->map(function ($media) {
                return $media->getUrl();
        });

        $pageData = [
            'id' => $page->id,
            'title' => $page->title ?? 'No title available.',
            'type' => $page->page_type,
            'content' => $page->content ?? 'No content available.',
            'views_count' => $page->views_count,
            'attachments' => $mediaUrls,
        ];

        $this->incrementViews($page);

        return view('site.pages.show', compact('pageData'));
    }
}
