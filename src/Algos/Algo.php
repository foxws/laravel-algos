<?php

namespace Foxws\Algos\Algos;

use Foxws\Algos\Enums\Status;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use stdClass;
use Stringable;

abstract class Algo implements Stringable
{
    use Conditionable;
    use Macroable;

    protected ?string $name = null;

    protected ?string $label = null;

    abstract public function handle(): Result;

    public static function make(): static
    {
        return app(static::class);
    }

    public function run(): mixed
    {
        return $this->handle();
    }

    public function runIf(bool $boolean): mixed
    {
        return $boolean ? $this->run() : new stdClass;
    }

    public function runUnless(bool $boolean): mixed
    {
        return $this->runIf(! $boolean);
    }

    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): string
    {
        if ($this->label) {
            return $this->label;
        }

        $name = $this->getName();

        return Str::of($name)->snake()->replace('_', ' ')->title();
    }

    public function getName(): string
    {
        if ($this->name) {
            return $this->name;
        }

        $baseName = class_basename(static::class);

        return Str::of($baseName)->beforeLast('Algo');
    }

    public function markAsFailed(): Result
    {
        return Result::make()->status(Status::Failed);
    }

    public function markAsSuccess(): Result
    {
        return Result::make()->status(Status::Success);
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
