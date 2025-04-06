<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        // Use our helper or direct call to get the maintenance mode setting
        $maintenanceMode = Cache::remember('settings_main_maintenance_mode', 43200, function () {
            return Setting::get('maintenance_mode', 'main', false);
        });
        
        $secretKey = Cache::remember('settings_main_secret_key', 43200, function () {
            return Setting::get('secret_key', 'main', '');
        });

        if (($maintenanceMode) || (config('app.env') === 'production' && config('app.debug'))) {
            if ($request->query('key') === $secretKey) {
                return $next($request);
            }

            if ($request->user() && $request->user()->isAdmin()) {
                return $next($request);
            }

            if ($request->is('login') && $request->isMethod('post')) {
                return $next($request);
            }

            return response()->view('misc.core.maintenance');
        }

        return $next($request);
    }
}
