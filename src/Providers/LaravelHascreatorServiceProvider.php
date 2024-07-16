<?php

namespace JuniorFontenele\LaravelHascreator\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class LaravelHascreatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/hascreator.php',
            'hascreator'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/hascreator.php' => config_path('hascreator.php'),
        ], 'config');

        Blueprint::macro('creator', function () {
            $columnName = config('hascreator.column_name');
            $model = config('hascreator.model');
            $tableName = app($model)->getTable();

            $this->foreignId($columnName)
                ->nullable()
                ->constrained($tableName)
                ->nullOnDelete();
        });
    }
}
