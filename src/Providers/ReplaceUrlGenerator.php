<?php

namespace BinaryCats\LaravelTenant\Providers;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Routing\UrlGenerator as UrlGeneratorContract;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class ReplaceUrlGenerator extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        if (config('tenant.routing.autobind')) {
            $this->replaceUrlGenerator();
        }
    }

    /**
     * Override the UrlGenerator.
     *
     * @return void
     */
    protected function replaceUrlGenerator()
    {
        // extend the existing UrlGenerator
        $this->app->extend(
            UrlGenerator::class, function ($urlGenerator) {
                // pick the correct generator
                $urlGenerator = $this->app['config']->get('tenant.routing.generator') ?? $urlGenerator;
                // re-bind the class
                return new $urlGenerator(
                    $this->app['router']->getRoutes(),
                    $this->app['request'],
                    $this->app['config']->get('app.asset_url')
                );
            }
        );

        $this->app->extend(
            'url', function (UrlGeneratorContract $url, $app) {
                // Next we will set a few service resolvers on the URL generator so it can
                // get the information it needs to function. This just provides some of
                // the convenience features to this URL generator like "signed" URLs.
                $url->setSessionResolver(
                    function () {
                        return $this->app['session'] ?? null;
                    }
                );

                $url->setKeyResolver(
                    function () {
                        return $this->app->make('config')->get('app.key');
                    }
                );

                // If the route collection is "rebound", for example, when the routes stay
                // cached for the application, we will need to rebind the routes on the
                // URL generator instance so it has the latest version of the routes.
                $app->rebinding(
                    'routes', function ($app, $routes) {
                        $app['url']->setRoutes($routes);
                    }
                );

                return $url;
            }
        );
    }
}
