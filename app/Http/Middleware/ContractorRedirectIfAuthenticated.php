<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContractorRedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('contractor_id')) {
            return redirect()->route('contractors.dashboard');
        }
        return $next($request);
    }
}