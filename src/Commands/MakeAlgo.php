<?php

namespace Foxws\LaravelAlgos\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class MakeWorkflow extends GeneratorCommand
{
    protected $name = 'make:algo';

    protected $description = 'Create a new algo class';

    protected $type = 'Action';

    protected function getStub(): string
    {
        return file_exists($customPath = $this->laravel->basePath('stubs/algo.stub'))
            ? $customPath
            : __DIR__.'/../stubs/algo.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return "{$rootNamespace}\\Algos";
    }

    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the workflow class.'],
        ];
    }
}