<?php

use Foxws\Algos\Enums\Status;
use Foxws\Algos\Tests\Models\Post;
use Foxws\Algos\Tests\Models\User;
use Foxws\Algos\Tests\TestCase;
use Foxws\Algos\Tests\TestClasses\FakeCollectionAlgo;

uses(TestCase::class);

beforeEach(function () {
    $this->users = User::factory(3)->create();
    $this->posts = Post::factory(3)->create();
});

it('will determine that algo is success', function () {
    $result = FakeCollectionAlgo::make()->run();

    expect($result->status)->toBe(Status::Success);
});
