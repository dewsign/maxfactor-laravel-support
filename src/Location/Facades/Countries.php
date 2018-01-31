<?php

namespace Maxfactor\Support\Location\Facades;

use Illuminate\Support\Facades\Facade;

class Countries extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mx-countries';
    }
}
