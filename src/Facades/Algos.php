<?php

namespace Foxws\LaravelAlgos\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Foxws\Algos\Algos
 */
class Algos extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Foxws\Algos\Algos::class;
    }
}
