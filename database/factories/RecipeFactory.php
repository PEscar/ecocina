<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Recipe;
use Faker\Generator as Faker;

$factory->define(Recipe::class, function (Faker $faker) {
    return [
		'entity_id' => null,
    	'detail' => $faker->sentence(10, 20),
        'extra_cost' => $faker->randomFloat(2, 0, 100),
        'quantity' => $faker->randomFloat(2, 0, 100),
        'name' => $faker->name,
    ];
});