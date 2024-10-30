<?php

namespace Foxws\Algos\Tests\TestClasses;

use Foxws\Algos\Algos\Algo;
use Foxws\Algos\Algos\Result;
use Foxws\Algos\Tests\Models\Post;
use Foxws\Algos\Tests\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\Uid\Ulid;

class GenerateUserFeed extends Algo
{
    protected ?User $user = null;

    public function handle(): Result
    {
        $hash = $this->generateUniqueId();

        cache()->set(
            key: $hash,
            value: ['ids' => (array) $this->getCollection()],
            ttl: now()->addMinutes(10),
        );

        return $this
            ->success('Feed generated successfully')
            ->with('hash', $hash);
    }

    public function model(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    protected function getCollection(): Collection
    {
        return Post::query()
            ->select('id')
            ->inRandomOrder()
            ->take(5)
            ->get();
    }

    protected function generateUniqueId(): string
    {
        Str::createUlidsUsing(function () {
            return new Ulid('01HRDBNHHCKNW2AK4Z29SN82T9');
        });

        return Str::ulid();
    }
}
