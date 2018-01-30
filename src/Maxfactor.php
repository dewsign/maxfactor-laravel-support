<?php

namespace Maxfactor\Support;

use Illuminate\Support\Carbon;
use Maxfactor\Support\Location\Facades\Countries;

class Maxfactor
{
    public function countries()
    {
        return Countries::list();
    }

    public function currentYear()
    {
        return Carbon::now()->format('Y');
    }
}
