<?php

namespace Elutiger\Weworkapi\Facades;

use Illuminate\Support\Facades\Facade;
 
/**
 * @see \Elutiger\Weworkapi\CorpAPI
 */
class Weworkapi extends Facade
{
     

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'CorpAPI';
    }
}
