<?php

use App\Department;
use Illuminate\Support\Str;
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

$factory->define(Department::class, function (Faker $faker) {
    return [
        'name' => $faker->streetName,
        'description' => $faker->streetAddress,
        'logo' => '4pixels-logo.jpg',
    ];
});
