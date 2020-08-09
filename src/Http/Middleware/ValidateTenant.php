<?php

namespace BinaryCats\LaravelTenant\Http\Middleware;

use Closure;
use BinaryCats\LaravelTenant\TenantManager;
use BinaryCats\LaravelTenant\Exceptions\TenantExpection;
use Illuminate\Http\Request;

class ValidateTenant
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
        if ($request->hasSubdomain()) {
            // Verify the tenant exists
            $this->verifyTenant($request);
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
    protected function verifyTenant(Request $request)
    {
        // if tenant is not valid:
        if (! $this->tenant($request)) {
            // and now
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
}
