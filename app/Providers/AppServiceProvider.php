<?php

namespace DomainProvider\Providers;

use Illuminate\Support\ServiceProvider;
use DomainProvider\Services\CloudflareAPI;
use DomainProvider\Services\Domain;
use DomainProvider\Services\Setting;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        // developmen service provider
        if ('local' === $this->app->environment() && config('app.debug')) {
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        }

        // application service container
        $this->app->bind('cloudflare', function ($app) {
            return new CloudflareAPI();
        });

        $this->app->bind('domain', function ($app) {
            return new Domain(
                $app['DomainProvider\Repositories\BlacklistDomainRepository'],
                $app['DomainProvider\Repositories\UserDomainRepository'],
                $app['DomainProvider\Repositories\UserRepository'],
                $app['DomainProvider\Repositories\ZoneRepository']
            );
        });

        $this->app->bind('app_setting', function ($app) {
            return new Setting($app['DomainProvider\Repositories\SettingRepository']);
        });
    }
}
