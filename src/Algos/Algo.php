<?php

namespace Foxws\Algos\Algos;

use Foxws\Algos\Enums\Status;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Stringable;

abstract class Algo implements Arrayable, Jsonable, Stringable
{
    use Conditionable { unless as doUnless; }
    use Macroable;

    protected ?string $name = null;

    protected ?string $label = null;

    /** @var array<bool|callable(): bool> */
    protected array $shouldRun = [];

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

    public function getRunConditions(): array
    {
        return $this->shouldRun;
    }

    public function shouldRun(): bool
    {
        foreach ($this->shouldRun as $shouldRun) {
            $shouldRun = is_callable($shouldRun) ? $shouldRun() : $shouldRun;

            if (! $shouldRun) {
                return false;
            }
        }

        return true;
    }

    public function if(bool|callable $condition): static
    {
        $this->shouldRun[] = $condition;

        return $this;
    }

    public function unless(bool|callable $condition): static
    {
        $this->shouldRun[] = is_callable($condition) ? fn () => ! $condition() : ! $condition;

        return $this;
    }

    public function markAsFailed(): Result
    {
        return Result::make()->status(Status::Failed);
    }

    public function toArray(): array
    {
        return [];
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
