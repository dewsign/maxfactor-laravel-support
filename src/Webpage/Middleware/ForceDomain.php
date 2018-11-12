<?php

namespace Maxfactor\Support\Webpage\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class ForceDomain
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

        if (!in_array($response->getStatusCode(), config('maxfactor-support.enforceDomainsStatusCodes'))) {
            return $response;
        }

        return $this->validDomain($request, $response);
    }

    private function validDomain(&$request, $response)
    {
        $redirect = false;
        $actualDomain = parse_url(url()->current());

        $appUrl = parse_url(config('app.url'));
        $primaryDomain = array_get($appUrl, 'host');
        $useSsl = array_get($appUrl, 'scheme', 'https') === 'https';

        $allowedDomains = array_merge([$primaryDomain], config('maxfactor-support.allowedDomains', []));

        if (!in_array($request->header('host'), $allowedDomains)) {
            $request->headers->set('host', $primaryDomain);
            $redirect = true;
        }

        if ($request->isSecure() !== $useSsl) {
            $request->server->set('HTTPS', $useSsl);
            $redirect = true;
        }

        return $redirect ? redirect(url($request->fullUrl()), 301) : $response;
    }
}
