<?php

namespace Maxfactor\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Maxfactor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'maxfactor';
    }
}
