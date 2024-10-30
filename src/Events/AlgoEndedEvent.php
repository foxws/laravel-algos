<?php

namespace Foxws\Algos\Events;

use Foxws\Algos\Algos\Algo;
use Foxws\Algos\Algos\Result;

class AlgoEndedEvent
{
    public function __construct(
        public Algo $check,
        public Result $result,
    ) {}
}
