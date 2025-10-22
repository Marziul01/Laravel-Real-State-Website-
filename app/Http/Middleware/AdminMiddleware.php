<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in and has role = 0 (admin)
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 0) {
            return $next($request);
        }

        // If not admin, redirect to home or show 403 page
        return redirect(route('login'))->with('error', 'Access denied! Admins only.');
    }
}
