<?php

namespace Maxfactor\Support\Video\Facades;

use Illuminate\Support\Facades\Facade;

class Video extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mx-video';
    }
}
