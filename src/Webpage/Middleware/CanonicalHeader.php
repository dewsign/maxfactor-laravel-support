<?php

namespace Maxfactor\Support\Webpage\Middleware;

use Closure;

class CanonicalHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (!property_exists($response, 'original')) {
            return $response;
        }

        if (!$original = $response->original) {
            return $response;
        }

        if (!method_exists($original, 'getData')) {
            return $response;
        }

        $responseData = collect($original->getData())->toArray();

        $canonical = collect($responseData)->map(function ($item, $key) {
            return collect($item)->get('canonical') ?? null;
        })->first();

        if ($canonical) {
            $response->header(
                'Link',
                sprintf('<%s>; rel="canonical"', secure_url($canonical))
            );
        }

        return $response;
    }
}
