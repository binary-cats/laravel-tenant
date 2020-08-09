<?php

namespace BinaryCats\LaravelTenant\Routing;

use Illuminate\Support\Arr;
use Illuminate\Routing\UrlGenerator as BaseUrlGenerator;

class UrlGenerator extends BaseUrlGenerator
{
    /**
     * Name of the subdomain key
     *
     * @var string
     */
    protected $subdomainKey;

    /**
     * Format the array of URL parameters.
     *
     * @param  mixed|array $parameters
     * @return array
     */
    public function formatParameters($parameters)
    {
        $this->getDefaultParameters();

        return parent::formatParameters($parameters);
    }

    /**
     * Set the default named parameters used by the URL generator.
     *
     * @param  array $defaults
     * @return void
     */
    public function getDefaultParameters()
    {
        if ($subdomain = $this->getSubdomain()) {
            return $this->defaults(
                [
                $this->subdomainKey() => $subdomain
                ]
            );
        }
    }

    /**
     * Get subdomain from route
     *
     * @return string | null
     */
    protected function getSubdomain()
    {
        return $this->getRouteParameter() ?: $this->getDefaultSubdomain();
    }

    /**
     * Resolve the parameter from route
     *
     * @return string
     */
    protected function getRouteParameter()
    {
        return $this->request->route($this->subdomainKey());
    }

    /**
     * Get Default Subsomain
     *
     * @return string | null
     */
    protected function getDefaultSubdomain()
    {
        if ($tenant = tenant()) {
            return $tenant->domain;
        }
    }

    /**
     * Return the subdomain key
     *
     * @return string
     */
    protected function subdomainKey() : string
    {
        return empty($this->subdomainKey) ? config('tenant.routing.subdomainKey') : $this->subdomainKey;
    }
}
