<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ConsultantAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('consultant_id')) {
            return redirect()->route('consultants.login.get')
                ->with('status', 'Please login to access your dashboard');
        }
        return $next($request);
    }
}