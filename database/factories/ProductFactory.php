<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'detail' => $faker->sentence(10, 20),
        'stock' => $faker->randomFloat(3, 0, 100),
        'average_cost' => $faker->randomFloat(3, 0, 100),
        'sales' => $faker->boolean(),
        'purchases' => $faker->boolean(),
        'productions' => $faker->boolean(),
        'measure' => 1,
    ];
});