<?php

namespace Maxfactor\Support;

use Maxfactor\Support\Location\Facades\Countries;

class Maxfactor
{
    public function countries()
    {
        return Countries::list();
    }
}
