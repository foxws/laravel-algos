<?php

namespace Foxws\Algos\Exceptions;

use Exception;
use Illuminate\Support\Collection;

class DuplicateAlgoNamesFound extends Exception
{
    public static function make(Collection $items): self
    {
        $duplicateAlgoNames = $items
            ->map(fn (string $name) => "`{$name}`")
            ->join(', ', ' and ');

        return new self("You registered algos with a non-unique name: {$duplicateAlgoNames}. Each algo should be unique. If you really want to use the same algo class twice, make sure to call `name()` on them to ensure that they all have unique names.");
    }
}
