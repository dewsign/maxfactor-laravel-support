<?php

namespace Maxfactor\Support;

use Maxfactor\Support\Maxfactor;
use Illuminate\Support\Facades\View;
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
        $this->bootCanonicalViewComposer();
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

    /**
     * Provides the maxfactor::components.canonical view with the canonical url from the view data
     *
     * @return void
     */
    private function bootCanonicalViewComposer()
    {
        View::composer('maxfactor::components.canonical', function ($view) {
            $responseData = collect($view->getData())->toArray();

            $canonical = collect($responseData)->map(function ($item, $key) {
                return collect($item)->get('canonical') ?? null;
            })->filter()->first();

            View::share('canonicalLink', $canonical);
        });
    }
}
