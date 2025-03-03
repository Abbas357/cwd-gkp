<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Event;
use App\Models\Story;
use App\Models\Slider;
use App\Models\Tender;
use App\Models\Gallery;
use App\Models\Download;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;

class HomeController extends Controller
{
    public function websiteAdmin()
    {
        $publishedContent = 0;
        $draftContent = 0;
        $archivedContent = 0;
        $totalContent = 0;
        $totalViews = 0;
        
        $contentTypes = [
            'News' => News::class,
            'Event' => Event::class,
            'Tender' => Tender::class,
            'Gallery' => Gallery::class,
        ];
        
        $moduleStats = [];
        foreach ($contentTypes as $type => $model) {
            $published = $model::where('status', 'published')->count();
            $draft = $model::where('status', 'draft')->count();
            $archived = $model::where('status', 'archived')->count();
            $total = $model::count();
            $views = $model::sum('views_count');
            
            $publishedPercentage = $total > 0 ? ($published / $total) * 100 : 0;
            $draftPercentage = $total > 0 ? ($draft / $total) * 100 : 0;
            $archivedPercentage = $total > 0 ? ($archived / $total) * 100 : 0;
            
            $publishedContent += $published;
            $draftContent += $draft;
            $archivedContent += $archived;
            $totalContent += $total;
            $totalViews += $views;
            
            $moduleStats[$type] = [
                'published' => $published,
                'draft' => $draft,
                'archived' => $archived,
                'total' => $total,
                'views' => $views,
                'publishedPercentage' => $publishedPercentage,
                'draftPercentage' => $draftPercentage,
                'archivedPercentage' => $archivedPercentage
            ];
        }
        
        $otherContentTypes = [
            'Slider' => Slider::class,
            'Story' => Story::class,
            'Download' => Download::class,
            'Achievement' => Achievement::class
        ];
        
        foreach ($otherContentTypes as $model) {
            $totalContent += $model::count();
        }
        
        $publishedPercentage = $totalContent > 0 ? ($publishedContent / $totalContent) * 100 : 0;
        $draftPercentage = $totalContent > 0 ? ($draftContent / $totalContent) * 100 : 0;
        $archivedPercentage = $totalContent > 0 ? ($archivedContent / $totalContent) * 100 : 0;
        
        $contentStatusData = [
            ['status' => 'Published', 'count' => $publishedContent, 'color' => '#1cc88a'],
            ['status' => 'Draft', 'count' => $draftContent, 'color' => '#f6c23e'],
            ['status' => 'Archived', 'count' => $archivedContent, 'color' => '#e74a3b'],
        ];
        
        $mostViewedContent = collect();
        
        foreach ($contentTypes as $type => $model) {
            $mostViewed = $model::where('views_count', '>', 0)
                ->orderBy('views_count', 'desc')
                ->take(5)
                ->select('title', 'views_count', 'created_at', DB::raw("'$type' as type"))
                ->get();
            
            $mostViewedContent = $mostViewedContent->concat($mostViewed);
        }
        
        $mostViewedContent = $mostViewedContent
            ->sortByDesc('views_count')
            ->take(5)
            ->values()
            ->all();
        
        $contentCreationTrend = [];
        $viewsTrend = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $displayDate = now()->subDays($i)->format('M d');
            
            $dailyContent = 0;
            $dailyViews = 0;
            
            foreach ($contentTypes as $model) {
                $dailyContent += $model::whereDate('created_at', $date)->count();
                
                $dailyViews += $model::whereDate('updated_at', $date)->sum('views_count');
            }
            
            $contentCreationTrend[] = [
                'date' => $displayDate,
                'count' => $dailyContent
            ];
            
            $viewsTrend[] = [
                'date' => $displayDate,
                'views' => $dailyViews
            ];
        }
        
        $recentActivities = Activity::with('causer')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get()
            ->map(function ($activity) {
                $modelType = class_basename($activity->subject_type ?? '');
                $modelId = $activity->subject_id ?? null;
                
                $enhancedDescription = $activity->description;
                if ($modelType && $modelId) {
                    $enhancedDescription .= " ($modelType #$modelId)";
                }
                
                return [
                    'description' => $enhancedDescription,
                    'causer' => $activity->causer ? $activity->causer->name : 'System',
                    'causer_avatar' => $activity->causer && $activity->causer->avatar ? $activity->causer->avatar : null,
                    'created_at' => $activity->created_at,
                    'time_ago' => $activity->created_at->diffForHumans()
                ];
            });
        
        $performanceMetrics = [
            'totalViews' => $totalViews,
            'avgViewsPerContent' => $totalContent > 0 ? round($totalViews / $totalContent, 2) : 0,
            'publishedRatio' => number_format($publishedPercentage, 1) . '%',
            'trending' => $mostViewedContent[0] ?? null
        ];
        
        return view('admin.home.index', compact(
            'totalContent',
            'publishedContent',
            'draftContent',
            'archivedContent',
            'publishedPercentage',
            'draftPercentage',
            'archivedPercentage',
            'contentStatusData',
            'mostViewedContent',
            'viewsTrend',
            'contentCreationTrend',
            'recentActivities',
            'moduleStats',
            'performanceMetrics'
        ));
    }

    public function masterAdmin()
    {
        return view('misc.home');
    }

    public function searchLinks(Request $request)
    {
        $query = $request->input('query');
        $routes = Route::getRoutes();
        $searchResults = [];
        
        $recentSearches = Session::get('recent_searches', []);

        foreach ($routes as $route) {
            $uri = $route->uri();
            
            if (in_array('GET', $route->methods()) && 
                !str_contains($uri, '{') && 
                str_contains($uri, 'admin')) {
                
                if (empty($query) || stripos($uri, $query) !== false) {
                    $searchResults[] = [
                        'title' => ucwords(str_replace(['admin/', '/', '-', '_'], ' ', trim($uri, '/'))),
                        'url' => url($uri)
                    ];
                }
            }
        }

        if ($query && !in_array($query, $recentSearches)) {
            array_unshift($recentSearches, $query);
            $recentSearches = array_slice($recentSearches, 0, 5);
            Session::put('recent_searches', $recentSearches);
        }

        return response()->json([
            'results' => $searchResults,
            'recentSearches' => $recentSearches
        ]);
    }

    public function clearRecentSearches()
    {
        Session::forget('recent_searches');
        return response()->json(['message' => 'Recent searches cleared']);
    }
}
