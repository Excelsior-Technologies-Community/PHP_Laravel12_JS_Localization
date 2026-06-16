<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    if (!function_exists('__db')) {
        function __db($key) {
       
            if (\Illuminate\Support\Facades\Schema::hasTable('translations')) {
                $translation = \App\Models\Translation::where('key', $key)->first();
                return $translation ? $translation->{app()->getLocale()} : __("messages.{$key}");
            }
            return __("messages.{$key}");
        }
    }
}
}
