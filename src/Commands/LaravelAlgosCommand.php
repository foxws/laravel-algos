<?php

namespace Foxws\LaravelAlgos\Commands;

use Illuminate\Console\Command;

class LaravelAlgosCommand extends Command
{
    public $signature = 'laravel-algos';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
