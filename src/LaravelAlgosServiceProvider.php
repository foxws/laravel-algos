<?php

namespace Foxws\LaravelAlgos;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Foxws\LaravelAlgos\Commands\LaravelAlgosCommand;

class LaravelAlgosServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-algos')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_algos_table')
            ->hasCommand(LaravelAlgosCommand::class);
    }
}
