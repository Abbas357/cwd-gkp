<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StandardizationAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('standardization_id')) {
            return redirect()->route('standardizations.login.get')
                ->with('status', 'Please login to access your dashboard');
        }
        return $next($request);
    }
}