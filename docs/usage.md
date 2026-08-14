---
sidebar_position: 3
---

# Usage

Generate an `Algo` class (you may also use `php artisan make:algo MyAlgo`):

```php
use Foxws\Algos\Algos\Algo;
use Foxws\Algos\Algos\Result;
use Foxws\Algos\Tests\Models\Post;
use Foxws\Algos\Tests\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class GenerateUserFeed extends Algo
{
    protected ?User $user = null;

    public function handle(): Result
    {
        $hash = $this->generateUniqueId();

        cache()->set(
            $this->generateUniqueId(),
            ['ids' => (array) $this->getCollection()],
            now()->addMinutes(10),
        );

        return $this
            ->success('Feed generated successfully')
            ->with('hash', $hash);
    }

    public function model(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    protected function getCollection(): Collection
    {
        return Post::query()
            ->select('id')
            ->where('user_id', $this->user->getKey())
            ->inRandomOrder()
            ->take(5)
            ->get();
    }

    protected function generateUniqueId(): string
    {
        return Str::ulid();
    }
}
```

To run the algorithm:

```php
$algo = GenerateUserFeed::make()->model($user)->run();

// $algo->status; // success, failed, skipped
// $algo->message; // reason
// $algo->meta; // array of metadata
```
