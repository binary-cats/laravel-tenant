<?php

namespace BinaryCats\LaravelTenant\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class RequestMacros extends ServiceProvider
{
    /**
     * List new methods for Blade compiler
     *
     * @var Array
     */
    protected $methods = [
        'hasSubdomain',
        'getSubdomain',
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        foreach($this->methods as $directive){
            $this->{$directive}();
        }
    }

    /**
     * True if the we have a subdomain
     *
     * @return void
     */
    public function hasSubdomain()
    {
        Request::macro(
            'hasSubdomain', function () {
                // Get host
                $host = $this->getHost();
                // app URL
                $appUrl = config('app.url');
                // Assumptions
                // localhost - has no subdomains,
                // so in something.local something is a subdomain
                // localhost.local - is two parts
                // so in somethings.localhost.local, somethithins is a subdomain
                return substr_count($host, '.') > substr_count($appUrl, '.');
            }
        );
    }

    /**
     * Resolve subdomain from the Request
     *
     * @return void
     */
    public function getSubdomain()
    {
        Request::macro(
            'getSubdomain', function () {
                // if we have a subdomain
                if ($this->hasSubdomain()) {
                    return head(explode('.', $this->getHost(), 2));
                }
            }
        );
    }
}
