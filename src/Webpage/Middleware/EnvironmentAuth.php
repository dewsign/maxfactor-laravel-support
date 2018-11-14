<?php

namespace Maxfactor\Support\Webpage\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;

class EnvironmentAuth extends AuthenticateWithBasicAuth
{
    /**
     * Only allow authenticated users on environments specified in the auth config.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null, $field = null)
    {
        if (!App::environment(config('auth.environments', ['staging']))) {
            return $next($request);
        }

        return parent::handle($request, $next, $guard);
    }
}
