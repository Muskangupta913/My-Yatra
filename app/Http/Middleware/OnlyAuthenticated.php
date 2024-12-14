<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            // Admin routes
            if ($request->is('admin/*') && auth()->user()->is_admin == 1) {
                return $next($request);
            }

            // Sales routes
            if ($request->is('sales/*') && auth()->user()->is_sales == 1) {
                return $next($request);
            }

            // Unauthorized access
            return redirect()->route('loginView')->with('error', 'Unauthorized access!');
        }

        // Redirect to login if not authenticated
        return redirect()->route('loginView');
    }
}
