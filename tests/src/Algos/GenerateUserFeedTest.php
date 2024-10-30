<?php

use Foxws\Algos\Enums\Status;
use Foxws\Algos\Tests\Models\User;
use Foxws\Algos\Tests\TestCase;
use Foxws\Algos\Tests\TestClasses\GenerateUserFeed;

uses(TestCase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('will determine that algo is success', function () {
    $result = GenerateUserFeed::make()->run($this->user);

    expect($result->status)->toBe(Status::Success);
});
