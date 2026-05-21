<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function change($locale)
    {
        if (!in_array($locale, ['en', 'hi'])) {
            $locale = 'en';
        }

        session(['locale' => $locale]);
        App::setLocale($locale);

        return redirect('/lang/' . $locale);
    }

    // NEW: AJAX method for real-time language switching
    public function switchLanguage(Request $request)
    {
        $locale = $request->locale;
        
        if (!in_array($locale, ['en', 'hi'])) {
            $locale = 'en';
        }

        session(['locale' => $locale]);
        App::setLocale($locale);

        // Get all translations for current language
        $translations = [
            'welcome' => __('messages.welcome'),
            'greeting' => __('messages.greeting'),
            'current_locale' => app()->getLocale(),
            'language_name' => $locale == 'en' ? 'English' : 'हिन्दी (Hindi)',
            'translation_count' => count(trans('messages')),
            'switch_message' => $locale == 'en' ? 'Language switched to English!' : 'भाषा बदलकर हिंदी की गई!'
        ];

        return response()->json($translations);
    }

    // NEW: Get specific translation
    public function getTranslation($key, $locale)
    {
        App::setLocale($locale);
        $translation = __("messages.{$key}");
        
        return response()->json([
            'key' => $key,
            'translation' => $translation,
            'locale' => $locale
        ]);
    }
}