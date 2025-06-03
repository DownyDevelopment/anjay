<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        if (!$request->user()->hasRole($roles)) {
            return redirect()->route('login')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
} 