<?php

namespace Foxws\Algos\Tests;

use Foxws\Algos\AlgosServiceProvider;
use Foxws\Algos\Tests\Database\Seeders\PostSeeder;
use Foxws\Algos\Tests\Database\Seeders\UserSeeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    use WithWorkbench;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
        $this->seedModels($this->app);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('cache.default', 'array');

        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            AlgosServiceProvider::class,
        ];
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function setUpDatabase($app)
    {
        Schema::dropAllTables();

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('title');
            $table->text('content')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    protected function seedModels($app): void
    {
        $this->seed(UserSeeder::class);
        $this->seed(PostSeeder::class);
    }
}