<?php

namespace Foxws\Algos\Algos;

use Foxws\Algos\Enums\Status;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Fluent;
use Illuminate\Support\Traits\Macroable;

class Result implements Arrayable, Jsonable
{
    use Macroable;

    public Algo $algo;

    public ?Status $status = null;

    public ?string $message = null;

    public array $meta = [];

    public static function make(): static
    {
        return app(static::class);
    }

    public function algo(Algo $algo): static
    {
        $this->algo = $algo;

        return $this;
    }

    public function status(Status $status, ?string $message = null): static
    {
        $this->status = $status;

        $this->message = $message;

        return $this;
    }

    public function success(?string $message = null): static
    {
        return $this->status(Status::Success, $message);
    }

    public function failed(?string $message = null): static
    {
        return $this->status(Status::Failed, $message);
    }

    public function skipped(?string $message = null): static
    {
        return $this->status(Status::Skipped, $message);
    }

    public function with(string $key, mixed $value = null): static
    {
        $this->meta[$key] = $value;

        return $this;
    }

    public function merge(array $meta): static
    {
        $this->meta = array_merge_recursive($this->meta, $meta);

        return $this;
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    public function toFluent(): Fluent
    {
        return Fluent::make($this->toArray());
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'meta' => $this->meta,
        ];
    }
}
