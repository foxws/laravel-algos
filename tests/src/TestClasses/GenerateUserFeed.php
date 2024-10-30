<?php

namespace Foxws\Algos\Tests\TestClasses;

use Foxws\Algos\Algos\Algo;
use Foxws\Algos\Algos\Result;
use Foxws\Algos\Tests\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Str;

class GenerateUserFeed extends Algo
{
    public function handle(User $user): Result
    {
        $result = Result::make();

        $hash = $user->modelCache(
            $this->generateUniqueId(),
            ['ids' => (array) $this->getCollection()],
            now()->addMinutes(10)
        );

        $this->sendBroadcast($user, $hash);

        return $result->success();
    }

    protected function getCollection(): Collection
    {
        return User::query()
            ->select('id')
            ->inRandomOrder()
            ->take(5)
            ->get();
    }

    protected function generateUniqueId(): string
    {
        return Str::ulid();
    }

    protected function sendBroadcast(User $user, string $hash): void
    {
        Broadcast::broadcast(['user.'.$user->getKey()], 'FeedGenerated', ['hash' => $hash]);
    }
}
