<?php

namespace Maxfactor\Support\Webpage\Traits;

trait HasBreadcrumbs
{
    /**
     * Provides the breadcrumb for the front-end to render
     *
     * @return void
     */
    public function seed()
    {
        return collect([
            [
                'name' => 'Home',
                'url' => '/'
            ],
        ]);
    }
}
