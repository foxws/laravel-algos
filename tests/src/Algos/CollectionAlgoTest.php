<?php

use Foxws\Algos\Enums\Status;
use Foxws\Algos\Tests\TestCase;
use Foxws\Algos\Tests\TestClasses\FakeCollectionAlgo;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;

uses(TestCase::class);

it('will determine that algo is success', function () {
    $result = FakeCollectionAlgo::make()->run();

    expect($result->status)->toBe(Status::Success);
});
