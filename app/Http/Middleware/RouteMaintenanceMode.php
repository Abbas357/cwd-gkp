<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class RouteMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()->getName();
        
        $maintenanceRoutes = Cache::remember('settings_main_maintenance_routes', 43200, function () {
            $routes = setting('maintenance_routes', 'main', []);
            return is_string($routes) ? json_decode($routes, true) : $routes;
        });
        
        foreach ($maintenanceRoutes as $route => $isLocked) {
            if ($isLocked && str_ends_with($route, '*')) {
                $groupPrefix = rtrim($route, '*');
                if (str_starts_with($routeName, $groupPrefix)) {
                    return response()->view('misc.core.route_maintenance', [
                        'routeName' => $routeName
                    ]);
                }
            } elseif ($isLocked && $route === $routeName) {
                return response()->view('misc.core.route_maintenance', [
                    'routeName' => $routeName
                ]);
            }
        }
        
        return $next($request);
    }
}