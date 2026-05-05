<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;

Route::get('/', function () {
    return redirect('/lang/en');
});

// ONLY display page here (NO redirect logic inside controller)
Route::get('/lang/{locale}', function ($locale) {

    if (!in_array($locale, ['en', 'hi'])) {
        $locale = 'en';
    }

    session(['locale' => $locale]);

    app()->setLocale($locale);

    return view('welcome');
});