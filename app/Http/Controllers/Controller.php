<?php

namespace DomainProvider\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Application Base Controller
 */
abstract class Controller extends BaseController
{
    use DispatchesCommands, ValidatesRequests;
}
