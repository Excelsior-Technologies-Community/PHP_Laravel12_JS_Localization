<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Locale
    |--------------------------------------------------------------------------
    |
    | If no locale is set, this locale will be used.
    |
    */

    'defaultLocale' => config('app.locale'),

    /*
    |--------------------------------------------------------------------------
    | Supported Locales
    |--------------------------------------------------------------------------
    |
    | Add the locales that you want to make available to JavaScript.
    |
    */

    'supportedLocales' => [
        'en',
        'hi',
    ],

    /*
    |--------------------------------------------------------------------------
    | Language Files Path
    |--------------------------------------------------------------------------
    |
    | Path to the language files directory.
    |
    */

    'langPath' => resource_path('lang'),

    /*
    |--------------------------------------------------------------------------
    | JavaScript Route Name
    |--------------------------------------------------------------------------
    |
    | Route where the JavaScript localization file will be accessible.
    |
    */

    'routeName' => 'assets.lang',

    /*
    |--------------------------------------------------------------------------
    | JavaScript Route URL
    |--------------------------------------------------------------------------
    |
    | URL that will serve the localization JS file.
    |
    */

    'routeUrl' => 'js/lang.js',

    /*
    |--------------------------------------------------------------------------
    | Cache Translations
    |--------------------------------------------------------------------------
    |
    | Cache translations for better performance in production.
    | Set false while developing.
    |
    */

    'cache' => false,

    /*
    |--------------------------------------------------------------------------
    | Cache Key
    |--------------------------------------------------------------------------
    |
    | Cache key used to store translations.
    |
    */

    'cacheKey' => 'js_localization',

];
