<?php

namespace DomainProvider\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'DomainProvider\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->pattern('id', '[0-9]+');

        // model binding
        $router->model('contact', 'DomainProvider\Models\Contact');
        $router->model('apikey', 'DomainProvider\Models\ApiKey');
        $router->model('zone', 'DomainProvider\Models\Zone');
        $router->model('blacklist_domain', 'DomainProvider\Models\BlacklistDomain');
        $router->model('page', 'DomainProvider\Models\Page');
        $router->model('user', 'DomainProvider\Models\User');
        $router->model('domain', 'DomainProvider\Models\UserDomain');
        $router->model('setting', 'DomainProvider\Models\Setting');
        $router->model('zonedns', 'DomainProvider\Models\DnsRecord');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
