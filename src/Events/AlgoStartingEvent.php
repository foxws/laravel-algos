<?php

namespace Foxws\Algos\Events;

use Foxws\Algos\Algos\Algo;

class AlgoStartingEvent
{
    public function __construct(
        public Algo $algo,
    ) {}
}
