<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Recipe;
use Faker\Generator as Faker;

$factory->define(Recipe::class, function (Faker $faker) {
    return [
    	'detail' => $faker->sentence(10, 20),
        'total_cost' => $faker->randomFloat(),
        'extra_cost' => $faker->randomFloat(),
        'quantity' => $faker->randomFloat(),
    ];
});