<?php

namespace phil404\beautifulcss;

use Illuminate\Support\ServiceProvider;

class beautifulCssServiceProvider extends ServiceProvider
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
        $this->app['beautifulcss'] = $this->app->share(function($app) {
            return new beautifulcss;
        });
    }
}