<?php

namespace Foxws\Algos\Tests\Database\Seeders;

use Foxws\Algos\Tests\Database\Factories\PostFactory;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        (new PostFactory(2))->create();
    }
}
