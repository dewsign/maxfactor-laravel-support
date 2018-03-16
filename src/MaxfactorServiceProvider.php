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
        $this->bootViews();
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

    /**
     * Load custom views
     *
     * @return void
     */
    private function bootViews()
    {
        $this->loadViewsFrom(__DIR__.'/Webpage/Views', 'maxfactor');

        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/maxfactor'),
        ]);
    }
}
