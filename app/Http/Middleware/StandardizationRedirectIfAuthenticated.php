<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StandardizationRedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('standardization_id')) {
            return redirect()->route('standardizations.dashboard');
        }
        return $next($request);
    }
}