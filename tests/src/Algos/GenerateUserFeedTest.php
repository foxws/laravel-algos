<?php

use Foxws\Algos\Enums\Status;
use Foxws\Algos\Tests\Models\Post;
use Foxws\Algos\Tests\Models\User;
use Foxws\Algos\Tests\TestCase;
use Foxws\Algos\Tests\TestClasses\GenerateUserFeed;

uses(TestCase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->posts = Post::factory(5)->create();
});

it('will determine that algo is success', function () {
    $algo = GenerateUserFeed::make()->forUser($this->user);

    $result = $algo->run();

    expect($result->status)->toBe(Status::Success);
});
