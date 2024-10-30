<?php

namespace Foxws\Algos;

use Foxws\Algos\Algos\Algo;
use Illuminate\Support\Collection;

class Algos
{
    /** @var array<int, Algo> */
    protected array $algos = [];

    /** @param  array<int, Algo> $algos */
    public function algos(array $algos): self
    {
        $this->ensureAlgoInstances($algos);

        $this->algos = array_merge($this->algos, $algos);

        $this->guardAgainstDuplicateAlgoNames();

        return $this;
    }

    public function clearAlgos(): self
    {
        $this->algos = [];

        return $this;
    }

    /** @return Collection<int, Algo> */
    public function registeredAlgos(): Collection
    {
        return collect($this->algos);
    }

    /** @param  array<int,mixed> $algos */
    protected function ensureAlgoInstances(array $algos): void
    {
        foreach ($algos as $algo) {
            if (! $algo instanceof Algo) {
                throw InvalidAlgo::doesNotExtendAlgo($algo);
            }
        }
    }

    protected function guardAgainstDuplicateAlgoNames(): void
    {
        $duplicateAlgoNames = collect($this->algos)
            ->map(fn(Algo $algo) => $algo->getName())
            ->duplicates();

        if ($duplicateAlgoNames->isNotEmpty()) {
            throw DuplicateAlgoNamesFound::make($duplicateAlgoNames);
        }
    }
}
