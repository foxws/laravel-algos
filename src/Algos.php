<?php

namespace Foxws\Algos;

use Exception;
use Foxws\Algos\Algos\Algo;
use Foxws\Algos\Algos\Result;
use Foxws\Algos\Events\AlgoEndedEvent;
use Foxws\Algos\Events\AlgoStartingEvent;
use Foxws\Algos\Exceptions\AlgoDidNotComplete;
use Foxws\Algos\Exceptions\DuplicateAlgoNamesFound;
use Illuminate\Support\Collection;
use Spatie\Health\Exceptions\InvalidAlgo;

class Algos
{
    /** @var array<int, Algo> */
    protected array $algos = [];

    /** @param  array<int, Algo> $algos */
    public function algos(array $algos): static
    {
        $this->ensureAlgoInstances($algos);

        $this->algos = array_merge($this->algos, $algos);

        $this->guardAgainstDuplicateAlgoNames();

        return $this;
    }

    public function runAlgo(Algo $algo): Result
    {
        event(new AlgoStartingEvent($algo));

        try {
            $result = $algo->run();
        } catch (Exception $exception) {
            $exception = AlgoDidNotComplete::make($algo, $exception);

            report($exception);

            $result = $algo->markAsFailed();
        }

        $result
            ->algo($algo)
            ->processed();

        event(new AlgoEndedEvent($algo, $result));

        return $result;
    }

    public function runAlgos(): Collection
    {
        return $this->registeredAlgos()
            ->map(fn (Algo $algo): Result => $algo->shouldRun()
                ? $this->runAlgo($algo)
                : Result::make()->algo($algo)->skipped()->processed()
            );
    }

    public function clearAlgos(): static
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
            ->map(fn (Algo $algo) => $algo->getName())
            ->duplicates();

        if ($duplicateAlgoNames->isNotEmpty()) {
            throw DuplicateAlgoNamesFound::make($duplicateAlgoNames);
        }
    }
}
