<?php

namespace App\Http\Middleware;

use App\Support\ArabicContent;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetPublicLocale
{
    public function __construct(private ArabicContent $arabicContent) {}

    /**
     * Apply the visitor's preferred locale to public pages only.
     *
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = config('app.supported_locales', ['en']);
        $requestedLocale = $request->query('lang');

        if (is_string($requestedLocale) && in_array($requestedLocale, $supportedLocales, true)) {
            $request->session()->put('locale', $requestedLocale);
        }

        $locale = $request->session()->get('locale', config('app.locale'));

        if (! is_string($locale) || ! in_array($locale, $supportedLocales, true)) {
            $locale = config('app.fallback_locale', 'en');
        }

        $previousLocale = App::currentLocale();
        App::setLocale($locale);

        if ($locale === 'ar') {
            $this->arabicContent->applyOverrides();
        }

        try {
            return $next($request);
        } finally {
            App::setLocale($previousLocale);
        }
    }
}
