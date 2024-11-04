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
        $settings = Cache::remember('settings', 43200, function () {
            return Setting::first();
        });

        if (($settings && $settings->maintenance_mode) || (config('app.env') === 'production' && config('app.debug'))) {
            $secret = $settings->secret_key;

            if ($request->query('key') === $secret) {
                return $next($request);
            }

            if ($request->user() && $request->user()->isAdmin()) {
                return $next($request);
            }

            if ($request->is('login') && $request->isMethod('post')) {
                return $next($request);
            }

            return response()->view('misc.maintenance');
        }

        return $next($request);
    }
}
