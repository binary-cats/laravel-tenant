<?php

namespace BinaryCats\LaravelTenant\Http\Middleware;

use Closure;
use BinaryCats\LaravelTenant\TenantManager;
use BinaryCats\LaravelTenant\Exceptions\TenantExpection;
use Illuminate\Http\Request;

class AuthorizeTenant
{
    /**
     * Bind implementation
     *
     * @var BinaryCats\LaravelTenant\TenantManager
     */
    protected $tenantManager;

    /**
     * Create new Middleware
     *
     * @param BinaryCats\LaravelTenant\TenantManager $tenantManager
     */
    public function __construct(TenantManager $tenantManager)
    {
        $this->tenantManager = $tenantManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if the user is authenticated and we have a subdomain
        if ($request->hasSubdomain()) {
            if ($request->user()) {
                // Set the tenant
                $this->applyTenant($request);
                // Remove account key from URL
                $this->forgetSubdomainKey($request);
            } else {
                abort(404);
            }
        }
        // continue
        return $next($request);
    }

    /**
     * Apply the Tenant to the scope
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function applyTenant(Request $request)
    {
        // if tenant is present
        if ($tenant = $this->tenant($request)) {
            // this is a tenant of the user
            if ($tenant->is($request->user()->tenant)) {
                return;
            }
            // possibly, related to plural tenants
            if ($tenant->hasModel($request->user())) {
                $this->tenantManager->setTenant($tenant);
            }
            // we do not have access, throw 403
            throw new TenantExpection("Access not allowed", 403);
        } else {
            throw new TenantExpection("Tenant does not exist", 404);
        }
    }

    /**
     * Resolve Tenant
     *
     * @param  \Illuminate\Http\Request $request
     * @return \BinaryCats\LaravelTenant\Models\Tenant
     */
    protected function tenant(Request $request)
    {
        return $this->tenantManager->findTenant(
            [
            'domain' => $request->getSubdomain(),
            ]
        );
    }

    /**
     * Forget the argument
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function forgetSubdomainKey(Request $request)
    {
        // Get the subdomainKey
        $subdomainKey = config('tenant.routing.subdomainKey');
        // remove it
        if ($route = $request->route()) {
            $route->forgetParameter($subdomainKey);
        }
    }
}
