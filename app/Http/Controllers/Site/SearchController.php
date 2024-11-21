<?php

namespace App\Http\Controllers\Site;

use App\Models\News;
use App\Models\Event;
use App\Models\Download;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DevelopmentProject;
use App\Models\Seniority;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $newsResults = $this->searchNews($query);
        $downloadResults = $this->searchDownloads($query);
        $eventResults = $this->searchEvents($query);
        $projectResults = $this->searchDevelopmentProjects($query);
        $seniorityResults = $this->searchSeniority($query);

        if (
            $newsResults->isEmpty() &&
            $downloadResults->isEmpty() &&
            $eventResults->isEmpty() &&
            $projectResults->isEmpty() &&
            $seniorityResults->isEmpty()
        ) {
            return response()->json([
                'success' => true,
                'data' => [
                    'result' => '<p class="cw-no-results">No results found.</p>',
                ],
            ]);
        }

        $html = view('layouts.site.partials.search', compact(
            'newsResults',
            'downloadResults',
            'eventResults',
            'projectResults',
            'seniorityResults'
        ))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    private function searchDevelopmentProjects(string $query)
    {
        return DevelopmentProject::where('name', 'LIKE', "%{$query}%")
            ->orWhere('introduction', 'LIKE', "%{$query}%")
            ->orWhereHas('district', function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('chiefEngineer', function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('superintendentEngineer', function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'LIKE', "%{$query}%");
            })
            ->latest()
            ->limit(5)
            ->get();
    }

    private function searchEvents(string $query)
    {
        return Event::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhere('location', 'LIKE', "%{$query}%")
            ->orWhere('event_type', 'LIKE', "%{$query}%")
            ->latest()
            ->limit(5)
            ->get();
    }

    private function searchNews(string $query)
    {
        return News::where('title', 'LIKE', "%{$query}%")
            ->orWhere('summary', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($news) {
                $mediaItem = $news->getFirstMedia('news_attachments');
                $news->image_url = asset('site/images/file-placeholder.png');
                if ($mediaItem && str_contains($mediaItem->mime_type, 'image')) {
                    $news->image_url = $mediaItem->getUrl();
                }
                return $news;
            });
    }

    private function searchDownloads(string $query)
    {
        return Download::where('file_name', 'LIKE', "%{$query}%")
            ->orWhere('file_type', 'LIKE', "%{$query}%")
            ->orWhere('category', 'LIKE', "%{$query}%")
            ->latest()
            ->limit(5)
            ->get();
    }

    private function searchSeniority(string $query)
    {
        return Seniority::where('title', 'LIKE', "%{$query}%")
            ->orWhere('designation', 'LIKE', "%{$query}%")
            ->orWhere('bps', 'LIKE', "%{$query}%")
            ->latest()
            ->limit(5)
            ->get();
    }
}
