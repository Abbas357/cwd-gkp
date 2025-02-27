<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function websiteAdmin()
    {
        return view('admin.home.index');
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
