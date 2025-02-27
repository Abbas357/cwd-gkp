<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\Setting;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RouteMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()->getName();
        $settings = Setting::first();
        $maintenanceRoutes = $settings->maintenance_routes ?? [];
        
        foreach ($maintenanceRoutes as $route => $isLocked) {
            if ($isLocked && str_ends_with($route, '*')) {
                $groupPrefix = rtrim($route, '*');
                if (str_starts_with($routeName, $groupPrefix)) {
                    return response()->view('misc.core.route_maintenance', [
                        'routeName' => $routeName
                    ]);
                }
            }
        }
        
        return $next($request);
    }
}
