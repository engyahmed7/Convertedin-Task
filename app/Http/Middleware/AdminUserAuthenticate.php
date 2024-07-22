<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminUserAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('Entering AdminUserAuthenticate middleware');

        if (Auth::guard('admin')->check()) {
            Log::info('Admin authenticated');
            return $next($request);
        } elseif (Auth::guard('web')->check()) {
            Log::info('User authenticated');
            return $next($request);
        }

        Log::info('Not authenticated, redirecting to login');
        return redirect('/login');
    }
}
