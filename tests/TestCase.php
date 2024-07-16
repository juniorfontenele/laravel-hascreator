<?php

namespace JuniorFontenele\LaravelHascreator\Tests;

use Illuminate\Config\Repository;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Workbench\App\Models\User;

use function Orchestra\Testbench\workbench_path;

class TestCase extends OrchestraTestCase
{
    protected $enablesPackageDiscoveries = false;

    protected bool $loadWorkbenchMigrations = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \JuniorFontenele\LaravelHascreator\Providers\LaravelHascreatorServiceProvider::class,
        ];
    }

    /**
     * Set up the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function defineEnvironment($app)
    {
        // Setup environment, like app configuration
        tap($app['config'], function (Repository $config) {
            $config->set('app.timezone', 'UTC');
            $config->set('app.locale', 'en');
            $config->set('app.fallback_locale', 'en');

            $config->set('database.default', 'sqlite');
            $config->set('database.connections.sqlite', [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]);

            $config->set('hascreator.model', User::class);
        });
    }

    /**
     * Set up the database.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function setUpDatabase($app)
    {
        $schema = $app['db']->connection()->getSchemaBuilder();

        // Create tables

        $schema->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->creator();
            $table->timestamps();
        });
    }

    protected function defineDatabaseMigrations()
    {
        if (! $this->loadWorkbenchMigrations) {
            return;
        }

        $this->loadMigrationsFrom(
            workbench_path('database/migrations')
        );
    }

    protected function getLaravelVersion()
    {
        return (float) app()->version();
    }
}
