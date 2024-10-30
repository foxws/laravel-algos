<?php

namespace Foxws\LaravelAlgos;

use Foxws\LaravelAlgos\Commands\LaravelAlgosCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
