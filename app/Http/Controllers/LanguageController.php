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

    public function switchLanguage(Request $request)
    {
        $locale = $request->locale;
        
        if (!in_array($locale, ['en', 'hi'])) {
            $locale = 'en';
        }

        session(['locale' => $locale]);
        App::setLocale($locale);

        $translations = [
            'welcome' => __db('welcome'),
            'greeting' => __db('greeting'),
            'current_locale' => app()->getLocale(),
            'language_name' => $locale == 'en' ? 'English' : 'हिन्दी (Hindi)',
            'translation_count' => count(trans('messages')),
            'switch_message' => $locale == 'en' ? 'Language switched to English!' : 'भाषा बदलकर हिंदी की गई!'
        ];

        return response()->json($translations);
    }

    public function getTranslation($key, $locale)
    {
        App::setLocale($locale);
        
        return response()->json([
            'key' => $key,
            'translation' => __db($key),
            'locale' => $locale
        ]);
    }
}