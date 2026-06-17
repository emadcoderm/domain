<?php

namespace DomainProvider\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /* @set($var++) */
        Blade::extend(function ($view) {
            return preg_replace('/\@set\((.+)\)/', '<?php ${1}; ?>', $view);
        });
    }

    public function register()
    {
        //
    }
}
