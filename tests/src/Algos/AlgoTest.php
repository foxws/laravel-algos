<?php

use Foxws\Algos\Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;

uses(TestCase::class);

it('can ', function () {
    $this->user->modelCache('cacheKey', 'cacheValue');
    $this->post->modelCache('cacheFoo', 'cacheBar');

    assertEquals('cacheValue', $this->user->modelCached('cacheKey'));
    assertEquals('cacheBar', $this->post->modelCached('cacheFoo'));

    $this->user->modelCacheForget('cacheKey');
    $this->post->modelCacheForget('cacheFoo');

    assertFalse($this->user->isModelCached('cacheKey'));
    assertFalse($this->post->isModelCached('cacheFoo'));
});
