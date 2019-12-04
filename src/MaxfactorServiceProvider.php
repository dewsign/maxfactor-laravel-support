<?php

namespace Maxfactor\Support;

use Maxfactor\Support\Maxfactor;
use Maxfactor\Support\Video\Video;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Maxfactor\Support\Location\Countries;
use Maxfactor\Support\Macros\CollectionPaginate;

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
        $this->registerBlueprints();
        $this->registerViewInactiveMacro();
        $this->bootMacros();
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
        $this->app->bind('mx-video', Video::class);

        $this->publishConfigs();
    }

    private function bootMacros()
    {
        return new CollectionPaginate;
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

    /**
     * Register additional table blueprints for use in database migrations
     *
     * @return void
     */
    private function registerBlueprints()
    {
        Blueprint::macro('active', function ($name = 'active', $default = false) {
            return $this->boolean($name)->default($default);
        });

        Blueprint::macro('featured', function ($name = 'featured', $default = false) {
            return $this->boolean($name)->default($default);
        });

        Blueprint::macro('sortable', function ($name = 'sort_order', $default = false) {
            return $this->integer($name)->default(1);
        });

        Blueprint::macro('meta', function ($name = 'meta_attributes') {
            return $this->json($name)->nullable();
        });

        Blueprint::macro('priority', function ($name = 'priority', $default = 50) {
            return $this->integer($name)->default($default);
        });

        Blueprint::macro('slug', function ($name = 'slug') {
            return $this->string($name)->unique()->index();
        });
    }

    public function publishConfigs()
    {
        $this->publishes([
            __DIR__.'/Config/maxfactor-support.php' => config_path('maxfactor-support.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__.'/Config/view-components.php', 'view-components');
        $this->mergeConfigFrom(__DIR__.'/Config/maxfactor-support.php', 'maxfactor-support');
    }

    /**
     * Register the viewInactive View Macro to be called via a controller
     *
     * @return void
     */
    private function registerViewInactiveMacro()
    {
        \Illuminate\View\View::macro('whenActive', function ($model) {
            abort_if(Gate::denies('viewInactive', $model), 503);
            return $this;
        });
    }
}
