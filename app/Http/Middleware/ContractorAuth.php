<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContractorAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('contractor_id')) {
            return redirect()->route('contractors.login.get')
                ->with('status', 'Please login to access your dashboard');
        }
        return $next($request);
    }
}