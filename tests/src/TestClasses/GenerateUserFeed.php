<?php

namespace Foxws\Algos\Tests\TestClasses;

use Foxws\Algos\Algos\Algo;
use Foxws\Algos\Algos\Result;
use Foxws\Algos\Tests\Models\Post;
use Foxws\Algos\Tests\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Str;

class GenerateUserFeed extends Algo
{
    protected ?User $user = null;

    public function handle(): Result
    {
        $result = Result::make();

        $hash = $this->user->modelCache(
            $this->generateUniqueId(),
            ['ids' => (array) $this->getCollection()],
            now()->addMinutes(10),
        );

        $this->sendBroadcast($hash);

        return $result->success();
    }

    public function forUser(User $user): static
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
        return Str::ulid();
    }

    protected function sendBroadcast(string $hash): void
    {
        Broadcast::broadcast(['user.'.$this->user->getKey()], 'FeedGenerated', [
            'hash' => $hash,
        ]);
    }
}
