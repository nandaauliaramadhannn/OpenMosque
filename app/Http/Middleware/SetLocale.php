<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Supported locales.
     */
    protected array $supportedLocales = ['en', 'ar', 'id', 'ms', 'tr', 'fr', 'ur', 'bn'];

    /**
     * RTL locales.
     */
    protected array $rtlLocales = ['ar', 'ur'];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Load dynamic settings
        $supportedLocales = \App\Models\Setting::getValue('active_languages', ['en', 'id', 'ar']);
        $defaultLocale = \App\Models\Setting::getValue('default_language', 'en');

        // Priority: Query string '?lang=' > URL segment > Session > Browser > Default
        $locale = $request->query('lang') ?: $request->segment(1);

        if (!in_array($locale, $supportedLocales)) {
            $locale = session('locale', $this->detectBrowserLocale($request, $supportedLocales, $defaultLocale));
        }

        if (!in_array($locale, $supportedLocales)) {
            $locale = $defaultLocale;
        }

        app()->setLocale($locale);
        session(['locale' => $locale]);

        // Share RTL direction with all views
        $isRtl = in_array($locale, $this->rtlLocales);
        view()->share('isRtl', $isRtl);
        view()->share('currentLocale', $locale);
        view()->share('supportedLocales', $supportedLocales);

        return $next($request);
    }

    /**
     * Detect browser's preferred language.
     */
    protected function detectBrowserLocale(Request $request, array $supportedLocales, string $defaultLocale): string
    {
        $browserLocale = $request->getPreferredLanguage($supportedLocales);
        return $browserLocale ?? $defaultLocale;
    }
}
