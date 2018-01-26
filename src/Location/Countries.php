<?php

namespace Maxfactor\Support\Location;

use Symfony\Component\Intl\Intl;

class Countries
{
    public function list(): array
    {
        return Intl::getRegionBundle()->getCountryNames();
    }
}
