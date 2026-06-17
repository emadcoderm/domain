<?php

namespace DomainProvider\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see DomainProvider\Services\Setting
 */
class Setting extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'app_setting';
    }
}
