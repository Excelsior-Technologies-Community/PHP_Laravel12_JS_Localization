# PHP_Laravel12_JS_Localization

## Project Description

PHP_Laravel12_JS_Localization is a Laravel 12 demonstration project that implements multi-language support with JavaScript integration.

This project allows users to dynamically switch between English and Hindi languages using URL-based localization. It also demonstrates how Laravel translation files can be accessed inside JavaScript using the Laravel JS Localization package.

The project is designed for beginners and developers who want to understand Laravel’s localization (i18n) system in a simple and practical way.


## Real-World Use Case

This project concept is useful for:

- Multi-language websites

- E-commerce platforms

- Admin dashboards

- International web applications

- SaaS platforms with global users





## Technologies Used

- Laravel 12

- PHP 8+

- MySQL (Optional)

- Laravel-JS-Localization Package

- HTML5

- CSS3

- JavaScript

- Composer



---



## Installation Steps


---


## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel12_JS_Localization "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_JS_Localization

```

#### Explanation:

Creates a fresh Laravel 12 application which will be used to build the localization system.



## STEP 2: Database Setup (Optional)

### Update database details:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_JS_Localization
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel12_JS_Localization

```

#### Explanation:

Configures Laravel to connect with MySQL database. Not mandatory for this project but useful for real applications.




## STEP 3: Install Laravel-JS-Localization Package

### Run:

```
composer require mariuzzo/laravel-js-localization

```

#### Explanation:

Installs a package that allows Laravel translation files to be accessed inside JavaScript.





## STEP 4: Publish Package Files

### Run:

```
php artisan vendor:publish --provider="Mariuzzo\LaravelJsLocalization\LaravelJsLocalizationServiceProvider"

```

### This will publish config at:

```
config/js-localization.php

```

#### Explanation:

Publishes the configuration file so we can customize localization settings.





## STEP 5: Configure the Package

### Open config/js-localization.php

#### Change locale path if needed, but default is fine:

```
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

```

#### Explanation:

Defines supported languages (English & Hindi) and sets the JavaScript translation route.





## STEP 6: Create Language File

1. English

### Create: resources/lang/en/messages.php

```
<?php

return [
    'welcome' => 'Welcome to Laravel JS Localization',
    'greeting' => 'Hello, :Name!',
];

```

2. Hindi

### Create: resources/lang/hi/messages.php

```
<?php

return [
    'welcome' => 'लारवेल जावास्क्रिप्ट लोकलाइजेशन में आपका स्वागत है',
    'greeting' =>  'नमस्ते, :Name!',
];

```

#### Explanation:

Creates translation files for each language inside resources/lang/ directory.





## STEP 7: Add Route for Language Switching

### Open routes/web.php and add:

```
<?php

use Illuminate\Support\Facades\Route;

Route::get('/{locale?}', function ($locale = 'en') {

    if (!in_array($locale, ['en', 'hi'])) {
        $locale = 'en';
    }

    app()->setLocale($locale);

    return view('welcome');
});

```

#### Explanation:

Creates a dynamic route that changes the application language based on URL parameter.




## STEP 8: Create SetLocale Middleware

### Create middleware:

```
php artisan make:middleware SetLocale

```

### Open: app/Http/Middleware/SetLocale.php

```
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('locale', config('app.locale'));
        App::setLocale($locale);

        return $next($request);
    }
}

```

#### Explanation:

Middleware reads selected language and sets the application locale globally.




## STEP 9: Register Middleware

### Modify the withMiddleware() section like this:

```
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        $middleware->append(\App\Http\Middleware\SetLocale::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();


```

#### Explanation:

Registers the custom middleware so Laravel applies language selection on every request.





## STEP 10: Update Blade File

### Open: resources/views/welcome.blade.php

#### Replace content with:

```
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>Laravel Localization</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 400px;
        }

        .locale {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        h1 {
            margin: 15px 0;
            color: #333;
        }

        .buttons {
            margin-top: 20px;
        }

        .btn {
            text-decoration: none;
            padding: 8px 18px;
            margin: 5px;
            border-radius: 6px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-en {
            background: #4CAF50;
            color: white;
        }

        .btn-hi {
            background: #ff9800;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>

    <div class="card">

        <div class="locale">
            Current Locale: <strong>{{ app()->getLocale() }}</strong>
        </div>

        <h1>{{ __('messages.welcome') }}</h1>

        <div class="buttons">
            <a href="/en" class="btn btn-en">English</a>
            <a href="/hi" class="btn btn-hi">हिंदी</a>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            let greeting = @json(__('messages.greeting', ['Name' => 'Demo']));
            alert(greeting);

        });
    </script>

</body>

</html>

```

#### Explanation:

Displays translated text on the page and passes translations to JavaScript using @json().




## STEP 11: Test the Project

### Start the server:

```
php artisan serve

```

### Open in browser:

```
http://127.0.0.1:8000

```


#### Explanation:

Starts Laravel development server and verifies language switching functionality in browser.




## Expected Output:

### Main Output:

<img width="1919" height="926" alt="Screenshot 2026-03-03 125556" src="https://github.com/user-attachments/assets/94baea66-9635-4a11-bd63-2e1a2ee3ff09" />


### English Output:


<img width="1919" height="748" alt="Screenshot 2026-03-03 125610" src="https://github.com/user-attachments/assets/5679b317-fb1c-430c-b3ec-88eea3d3f128" />

<img width="1919" height="874" alt="Screenshot 2026-03-03 125622" src="https://github.com/user-attachments/assets/d79a1024-d148-4d34-b51d-4206682bd93a" />

### Hindi Output:


<img width="1919" height="790" alt="Screenshot 2026-03-03 125631" src="https://github.com/user-attachments/assets/efbb43b0-bb15-4076-84f6-307985f2249e" />

<img width="1919" height="936" alt="Screenshot 2026-03-03 125657" src="https://github.com/user-attachments/assets/5260b32f-6757-4fe6-8197-e777f06e63f8" />



---

# Project Folder Structure:

```
PHP_Laravel12_JS_Localization
│
├── app
│   ├── Http
│   │   ├── Middleware
│   │   │   └── SetLocale.php
│   │   └── Controllers
│   │
│   └── Models
│
├── bootstrap
│   └── app.php
│
├── config
│   └── js-localization.php
│
├── database
│
├── public
│
├── resources
│   ├── lang
│   │   ├── en
│   │   │   └── messages.php
│   │   └── hi
│   │       └── messages.php
│   │
│   └── views
│       └── welcome.blade.php
│
├── routes
│   └── web.php
│
├── storage
│
├── tests
│
├── .env
├── composer.json
└── README.md
```
