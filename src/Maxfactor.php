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

    /**
     * Generate a Breadcrumb navigation trail. Set time travel to false to disable
     * forward navigation. Useful in Checkout for example.
     *
     * @param boolean $timetravel
     * @return Array|Collection
     */
    public static function bake($seed = [], bool $timetravel = true)
    {
        $future = false;

        $bread = collect($seed)->map(function ($crumb) use (&$future, $timetravel) {
            if (!$crumb) {
                return;
            }

            $status = $future && !$timetravel ? 'disabled' : 'enabled';
            $future = ($currentCrumb = (url()->all() === array_get($crumb, 'url')) ? 'current' : '') || $future;

            $crumb['status'] = $currentCrumb ? : $status;

            return $crumb;
        });

        return $bread;
    }
}
