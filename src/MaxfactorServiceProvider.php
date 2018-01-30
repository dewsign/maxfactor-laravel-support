<?php

namespace Maxfactor\Support;

use Maxfactor\Support\Maxfactor;
use Illuminate\Support\ServiceProvider;
use Maxfactor\Support\Location\Countries;

class MaxfactorServiceProvider extends ServiceProvider
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
        $this->app->bind('maxfactor', Maxfactor::class);
        $this->app->bind('mx-countries', Countries::class);
        $this->app->bind('mx-format', Format::class);
    }
}
