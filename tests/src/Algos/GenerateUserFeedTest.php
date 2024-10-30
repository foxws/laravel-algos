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
    $algo = GenerateUserFeed::make()->model($this->user)->run();

    expect($algo->status)->toBe(Status::Success);
});

it('will succeed with message', function () {
    $algo = GenerateUserFeed::make()->model($this->user)->run();

    expect($algo->message)->toBeString('Feed generated successfully');
});

it('will succeed with meta data', function () {
    $algo = GenerateUserFeed::make()->model($this->user)->run();

    expect($algo->meta['hash'])->toBeString('01HRDBNHHCKNW2AK4Z29SN82T9');
});
