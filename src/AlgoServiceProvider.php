<?php

namespace Foxws\Algos;

use Foxws\Algos\Commands\MakeAlgo;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AlgoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-algos')
            ->hasConfigFile('algos')
            ->hasCommands([
                MakeAlgo::class,
            ]);
    }

    public function packageRegistered(): void
    {
        $this->app->bind(Algo::class);
    }
}
