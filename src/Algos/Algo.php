<?php

namespace Foxws\Algos\Algos;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Stringable;

abstract class Algo implements Arrayable, Jsonable, Stringable
{
    use Conditionable;
    use Macroable;

    protected ?string $name = null;

    protected ?string $label = null;

    public static function make(): static
    {
        return app(static::class);
    }

    abstract public function run(): Result;

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

    public function __toString(): string
    {
        return $this->getName();
    }

    public function toArray(): array
    {
        return [];
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
