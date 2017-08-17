<?php

namespace shopping24\cssbeautifier;

use Illuminate\Support\ServiceProvider;

class CSSBeautifierServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['cssbeautifier'] = $this->app->share(function($app) {
            return new cssbeautifier;
        });
    }
}