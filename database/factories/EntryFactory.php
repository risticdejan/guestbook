<?php

use App\Entry;
use App\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Entry::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'subject' => $faker->sentence,
        'body' => $faker->text(1000),
        'user_id' => function () {
            return User::all()->random();
        },
        'email' => $faker->email
    ];

});
