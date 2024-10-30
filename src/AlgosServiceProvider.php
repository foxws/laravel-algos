<?php

namespace Foxws\Algos;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AlgosServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-algos')
            ->hasConfigFile('algos');
    }

    public function packageRegistered(): void
    {
        $this->app->bind(Algos::class);
    }
}
