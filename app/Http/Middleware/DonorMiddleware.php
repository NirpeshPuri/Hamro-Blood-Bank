<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and is a donor
        if (Auth::check() && Auth::user()->user_type === 'donor') {
            return $next($request);
        }

        // Redirect to login or show an error
        return redirect()->route('login')->with('error', 'You do not have access to this page.');
    }
}
