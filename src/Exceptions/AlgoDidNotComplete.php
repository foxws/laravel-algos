<?php

namespace Foxws\Algos\Exceptions;

use Exception;
use Foxws\Algos\Algos\Algo;

class AlgoDidNotComplete extends Exception
{
    public static function make(Algo $algo, Exception $exception): self
    {
        return new self(
            message: "The algo named `{$algo->getName()}` did not complete. An exception was thrown with this message: `".get_class($exception).": {$exception->getMessage()}`",
            previous: $exception,
        );
    }
}
