<?php

namespace Foxws\Algos\Tests\TestClasses;

use Foxws\Algos\Algos\Algo;
use Foxws\Algos\Algos\Result;
use Foxws\Algos\Tests\Models\Post;
use Foxws\Algos\Tests\Models\User;
use Illuminate\Support\Collection;

class FakeCollectionAlgo extends Algo
{
    protected ?Collection $users = null;

    protected ?Collection $posts = null;

    public function handle(): Result
    {
        $result = Result::make();

        $this->users = $this->getUsers();

        $this->posts = $this->getPosts();

        return $result->success();
    }

    protected function getUsers(): Collection
    {
        return User::query()
            ->take(5)
            ->get();
    }

    protected function getPosts(): Collection
    {
        return Post::query()
            ->take(5)
            ->get();
    }

    public function toArray(): array
    {
        return [
            'users' => $this->users,
            'posts' => $this->posts,
        ];
    }
}
