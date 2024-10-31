<?php

namespace Foxws\Algos\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Foxws\Algos\Algo
 */
class Algo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Foxws\Algos\Algo::class;
    }
}
