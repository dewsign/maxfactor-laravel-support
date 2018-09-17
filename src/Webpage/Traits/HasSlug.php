<?php

namespace Maxfactor\Support\Webpage\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Ensure the route uses the slug to identify a resource instead of the ID.
 */
trait HasSlug
{
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
