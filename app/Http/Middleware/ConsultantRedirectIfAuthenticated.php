<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ConsultantRedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('consultant_id')) {
            return redirect()->route('consultants.dashboard');
        }
        return $next($request);
    }
}