<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'detail' => $faker->sentence(10, 20),
        'stock' => 0,
        'average_cost' => 0,
        'sales' => $faker->boolean(),
        'purchases' => $faker->boolean(),
        'productions' => $faker->boolean(),
        'measure' => 1,
    ];
});