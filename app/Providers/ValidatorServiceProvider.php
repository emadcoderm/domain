<?php

namespace DomainProvider\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class ValidatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // validator ipv4
        Validator::extend('ipv4', function ($attribute, $value, $parameters) {
            return false !== filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        });

        // validator ipv6
        Validator::extend('ipv6', function ($attribute, $value, $parameters) {
            return false !== filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
        });

        // recaptcha
        Validator::extend('captcha', function ($attribute, $value) {
            if (!env('NOCAPTCHA_SECRET') || empty($value)) {
                return false;
            }

            $query = [
                'secret'   => env('NOCAPTCHA_SECRET'),
                'response' => $value,
                'remoteip' => $this->app['request']->getClientIp(),
            ];

            $link = 'https://www.google.com/recaptcha/api/siteverify?'.http_build_query($query);
            $response = json_decode(file_get_contents($link), true);

            if (empty($response)) {
                return false;
            }

            return isset($response['success']) && true === $response['success'];
        });
    }

    public function register()
    {
        //
    }
}
