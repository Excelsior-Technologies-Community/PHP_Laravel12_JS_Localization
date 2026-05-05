<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

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
}