<?php

namespace DomainProvider\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see DomainProvider\Services\CloudflareAPI
 */
class Cloudflare extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cloudflare';
    }
}
