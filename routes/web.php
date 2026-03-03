<?php

use Illuminate\Support\Facades\Route;

Route::get('/{locale?}', function ($locale = 'en') {

    if (!in_array($locale, ['en', 'hi'])) {
        $locale = 'en';
    }

    app()->setLocale($locale);

    return view('welcome');
});