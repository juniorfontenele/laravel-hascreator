<?php

namespace JuniorFontenele\LaravelHascreator\Tests;

use Illuminate\Support\Facades\Schema;
use Workbench\App\Models\User;

class HasCreatorTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_creator_is_set_when_creating_user()
    {
        $model = config('hascreator.model');
        $tableName = app($model)->getTable();
        $creatorColumn = config('hascreator.column_name');

        $this->assertTrue(Schema::hasColumn($tableName, $creatorColumn));

        $creator = User::create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ]);

        $this->assertNull($creator->{$creatorColumn});

        auth()->login($creator);

        $user = User::create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ]);

        $this->assertEquals($creator->id, $user->{$creatorColumn});
    }

    public function test_creator_is_not_set_when_auto_set_is_false()
    {
        $creatorColumn = config('hascreator.column_name');

        config(['hascreator.auto_set' => false]);

        $creator = User::create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ]);

        $this->assertNull($creator->{$creatorColumn});

        auth()->login($creator);

        $user = User::create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ]);

        $this->assertNull($user->{$creatorColumn});
    }
}
