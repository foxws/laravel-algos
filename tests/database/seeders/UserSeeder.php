<?php

namespace Foxws\Algos\Tests\Database\Seeders;

use Foxws\Algos\Tests\Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        (new UserFactory(2))->create();
    }
}
