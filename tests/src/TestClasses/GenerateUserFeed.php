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

        $key = $user->modelCache(
            $this->generateHash(),
            (array) $this->getCollection(),
            now()->addMinutes(10)
        );

        $this->sendBroadcast($user, $key);

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

    protected function generateHash(): string
    {
        return Str::ulid();
    }

    protected function sendBroadcast(User $user, string $hash): void
    {
        Broadcast::private('user.'.$user->getKey())
            ->as('FeedGenerated')
            ->with(['hash' => $hash])
            ->sendNow();
    }
}
