<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale');

        if (!$locale) {
            $locale = $request->getPreferredLanguage(['en', 'hi']);
            session(['locale' => $locale]);
        }

        if (!in_array($locale, ['en', 'hi'])) {
            $locale = 'en';
        }

        App::setLocale($locale);

        return $next($request);
    }
}