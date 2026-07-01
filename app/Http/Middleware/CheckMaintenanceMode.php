<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if maintenance mode is enabled in settings
        $isMaintenance = filter_var(Setting::getValue('maintenance_mode', false), FILTER_VALIDATE_BOOLEAN);

        // If enabled, block all requests EXCEPT those going to the admin panel
        if ($isMaintenance && !$request->is('admin*')) {
            abort(503, 'Situs sedang dalam perbaikan (Maintenance Mode).');
        }

        return $next($request);
    }
}
