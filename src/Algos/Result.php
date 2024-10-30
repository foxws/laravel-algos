<?php

namespace Foxws\Algos\Algos;

use Foxws\Algos\Enums\Status;
use Illuminate\Support\Carbon;

class Result
{
    public Algo $algo;

    public ?Status $status = null;

    public ?Carbon $processed = null;

    public ?string $message = null;

    public ?array $meta = null;

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

    public function meta(?array $meta = null): static
    {
        $this->meta = $meta;

        return $this;
    }

    public function processed(?Carbon $value = null): self
    {
        $this->processed = $value ?? now();

        return $this;
    }
}
