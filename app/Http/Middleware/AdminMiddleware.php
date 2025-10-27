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
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 0) {
            return $next($request);
        }

        // If admin session expired or not logged in
        if (!Auth::guard('admin')->check()) {
            return redirect(route('admin.login'))->with('error', 'Please log in as admin.');
        }

        return redirect(route('home'))->with('error', 'Access denied! Admins only.');
    }
}
