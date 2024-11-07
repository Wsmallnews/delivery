<?php

namespace Wsmallnews\Delivery\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Wsmallnews\Delivery\Delivery
 */
class Delivery extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Wsmallnews\Delivery\Delivery::class;
    }
}
