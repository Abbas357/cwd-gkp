<?php

namespace App\Http\Controllers\Site;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $newsItems = News::with(['media', 'user'])
            ->when($request->category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        $categories = News::select('category')->distinct()->pluck('category');

        return view('site.news.index', compact('newsItems', 'categories'));
    }

    public function showNews($slug)
    {
        $news = News::where('slug', $slug)->with(['media'])->firstOrFail();

        $newsData = [
            'id' => $news->id,
            'title' => $news->title,
            'slug' => $news->slug,
            'summary' => $news->summary ?? 'No summary available.',
            'content' => $news->content ?? 'No content available.',
            'category' => $news->category ?? 'General',
            'author' => $news->user->designation,
            'published_by' => $news->publishBy->designation,
            'published_at' => $news->published_at->format('M d, Y'),
            'image' => $news->getFirstMediaUrl('news_attachments')
                ?: asset('admin/images/no-image.jpg'),
        ];

        return view('site.news.show', compact('newsData'));
    }
}