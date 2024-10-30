<?php

namespace Foxws\Algos\Exceptions;

use Exception;
use Illuminate\Support\Collection;

class DuplicateAlgoNamesFound extends Exception
{
    public static function make(Collection $duplicateAlgoNames): self
    {
        return new self("Duplicate algo names found: `{$duplicateAlgoNames->implode(', ')}`.");
    }
}
