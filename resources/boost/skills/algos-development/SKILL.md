---
name: algos-development
description: >
  Write and run algorithm classes (algos) with foxws/laravel-algos, such as feeds or recommendations, that return a status, message and metadata.
license: MIT
metadata:
  author: francoism90
---

# Laravel Algos

Use this skill when a Laravel application builds algorithms (algos) with the `foxws/laravel-algos` package — e.g. a user feed, recommendations or a ranking — or works with `Foxws\Algos\Algos\Algo`, `Result` or `php artisan make:algo`.

## Concepts

- An algo is a class extending `Foxws\Algos\Algos\Algo` with one `handle(): Result` method.
- A `Result` has a `status` (`Foxws\Algos\Enums\Status`: `Success`, `Failed`, `Skipped`), an optional `message` and a `meta` array. It is `Arrayable` and `Jsonable`.
- Algos are resolved from the container (`make()`), so constructor dependencies are injected.

## Workflow

### 1. Install

- `composer require foxws/laravel-algos`

### 2. Generate an algo

```bash
php artisan make:algo GenerateUserFeed
```

This creates `app/Algos/GenerateUserFeed.php`.

### 3. Write `handle()`

```php
use Foxws\Algos\Algos\Algo;
use Foxws\Algos\Algos\Result;

class GenerateUserFeed extends Algo
{
    protected ?User $user = null;

    public function model(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function handle(): Result
    {
        if (! $this->user) {
            return $this->skipped('No user given');
        }

        $ids = Post::query()
            ->whereBelongsTo($this->user)
            ->inRandomOrder()
            ->take(5)
            ->pluck('id');

        return $this->success('Feed generated')->with('ids', $ids->all());
    }
}
```

- Return `$this->success()`, `$this->failed()` or `$this->skipped()`, each with an optional message.
- Add metadata with `->with($key, $value)` or `->merge([...])`; read it with `$result->get($key, $default)`.
- Add setters (like `model()` above) for the algo's input, returning `static` so calls chain.

### 4. Run it

```php
$result = GenerateUserFeed::make()->model($user)->run();

$result->status;          // Status::Success
$result->message;         // 'Feed generated'
$result->get('ids', []);  // [...]
```

- `runIf($condition)` / `runUnless($condition)` only run when the condition allows it (otherwise they return an empty `stdClass`, not a `Result`).
- `Algo` uses `Conditionable` (`when()` / `unless()`) and `Macroable`.
- `getName()` defaults to the class name without an `Algo` suffix and `getLabel()` to its title-cased form; override with `name()` / `label()`.

## Rules

- Keep algos side-effect light and return a `Result`; check `$result->status` instead of catching exceptions for expected outcomes like "nothing to do" (use `skipped`).
- Cache expensive results yourself (e.g. `cache()->remember()`) and return the cache key or IDs in `meta`.
- Run long algos in a queued job and store the `Result` (`toArray()` / `toJson()`), rather than in a request.

## References

- [usage.md](https://github.com/foxws/laravel-algos/blob/main/docs/usage.md)
