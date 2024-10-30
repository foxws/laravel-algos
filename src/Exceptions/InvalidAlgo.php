<?php

namespace Spatie\Health\Exceptions;

use Exception;

class InvalidAlgo extends Exception
{
    public static function doesNotExtendAlgo(string $algo): self
    {
        return new self("The algo `{$algo}` does not extend the `Algo` class.");
    }
}
