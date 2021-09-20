<?php

namespace Coder\LaravelDash;

use Illuminate\Support\Facades\Facade;

class DashFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'dash';
    }
}
