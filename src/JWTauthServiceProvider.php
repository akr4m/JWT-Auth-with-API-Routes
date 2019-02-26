<?php

namespace akr4m\jwtauth;

use Illuminate\Support\ServiceProvider;

class JWTauthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $routeConfig = [
            'namespace' => 'akr4m\jwtauth\Controllers\Auth',
            'prefix' => 'api',
            'middleware' => 'api',
        ];

        $this->getRouter()->group($routeConfig, function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        });

        $this->loadViewsFrom(__DIR__ . '/views/emails', 'emails');

        $this->publishes([
            __DIR__ . '/views/emails' => resource_path('views/emails'),
        ]);
    }

    /**
     * Get the active router.
     *
     * @return Router
     */
    protected function getRouter()
    {
        return $this->app['router'];
    }
}
