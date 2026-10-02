<?php

use Foxws\Algos\Algos\Result;
use Foxws\Algos\Tests\TestCase;

uses(TestCase::class);

it('converts a result to json', function () {
    $json = Result::make()->success('Done')->with('count', 5)->toJson();

    expect(json_decode($json, true))->toBe([
        'status' => 'success',
        'message' => 'Done',
        'meta' => ['count' => 5],
    ]);
});

it('fails instead of returning an empty string when the meta cannot be encoded', function () {
    Result::make()->with('name', "\xB1\x31")->toJson();
})->throws(JsonException::class);
