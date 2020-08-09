<?php

namespace BinaryCats\LaravelTenant\Http\Middleware;

use Closure;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class AuthenticateTenant
{
    /**
     * Name of the guard to autneticate against.
     *
     * @var string
     */
    protected $guard = 'api';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard($this->guard)->check()) {
            $this->fireAuthenticatedEvent(Auth::user());
        }

        return $next($request);
    }

    /**
     * Fire authenticated event to set the Tenant globally.
     *
     * @param  Illuminate\Contracts\Auth\Authenticatable $user
     * @return void
     */
    protected function fireAuthenticatedEvent(Authenticatable $user)
    {
        event(new Authenticated($this->guard, $user));
    }
}
