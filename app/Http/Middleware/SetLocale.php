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
        // Priority: URL segment > Session > Browser > Default
        $locale = $request->segment(1);

        if (!in_array($locale, $this->supportedLocales)) {
            $locale = session('locale', $this->detectBrowserLocale($request));
        }

        if (!in_array($locale, $this->supportedLocales)) {
            $locale = config('app.locale', 'en');
        }

        app()->setLocale($locale);
        session(['locale' => $locale]);

        // Share RTL direction with all views
        $isRtl = in_array($locale, $this->rtlLocales);
        view()->share('isRtl', $isRtl);
        view()->share('currentLocale', $locale);
        view()->share('supportedLocales', $this->supportedLocales);

        return $next($request);
    }

    /**
     * Detect browser's preferred language.
     */
    protected function detectBrowserLocale(Request $request): string
    {
        $browserLocale = $request->getPreferredLanguage($this->supportedLocales);
        return $browserLocale ?? config('app.locale', 'en');
    }
}
