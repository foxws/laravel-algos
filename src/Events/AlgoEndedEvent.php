<?php

namespace Foxws\Algos\Events;

use Foxws\Algos\Algos\Algo;
use Foxws\Algos\Algos\Result;

class AlgoEndedEvent
{
    public function __construct(
        public Algo $algo,
        public Result $result,
    ) {}
}
