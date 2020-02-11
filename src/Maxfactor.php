<?php

namespace Maxfactor\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
            $future = ($currentCrumb = (url()->full() === Arr::get($crumb, 'url')) ? 'current' : '') || $future;

            $crumb['status'] = $currentCrumb ? : $status;

            return $crumb;
        });

        return $bread;
    }

    /**
     * Returns a url with query string where the final querystring is a filtered
     * version of the current querystring.
     *
     * @param string $url
     * @param string $allowedParameters  Accepts a string or regular expression
     * @return string
     */
    public function urlWithQuerystring(string $url, string $allowedParameters = null) : string
    {
        if (!$allowedParameters) {
            return $url;
        }

        $allowedParameters = Str::start($allowedParameters, '/');
        $allowedParameters = Str::finish($allowedParameters, '/');

        $currentQuery = collect(request()->query())->filter(function ($value, $parameter) use ($allowedParameters) {
            return collect(\Arr::wrap($value))->filter(function ($value) use ($parameter, $allowedParameters) {
                return preg_match($allowedParameters, sprintf('%s=%s', $parameter, $value));
            })->count();
        });

        if (!$newQuery = http_build_query($currentQuery->all())) {
            return $url;
        };

        return sprintf('%s?%s', $url, $newQuery);
    }
}
