<?php

namespace DomainProvider\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see DomainProvider\Services\Domain
 */
class Domain extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'domain';
    }
}
