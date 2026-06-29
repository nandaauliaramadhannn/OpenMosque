<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     * Ensure user is authenticated and has admin-level access.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login')
                ->with('error', __('Please login to access the admin panel.'));
        }

        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect()->route('admin.login')
                ->with('error', __('Your account has been deactivated.'));
        }

        // All authenticated users can access admin (role checked per-feature)
        return $next($request);
    }
}
