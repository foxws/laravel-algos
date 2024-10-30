<?php

namespace Foxws\LaravelAlgos\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Foxws\LaravelAlgos\LaravelAlgos
 */
class LaravelAlgos extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Foxws\LaravelAlgos\LaravelAlgos::class;
    }
}
