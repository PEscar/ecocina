<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'detail' => $faker->sentence(10, 20),
        'stock' => $faker->randomFloat(),
        'sales' => $faker->boolean(),
        'shoppings' => $faker->boolean(),
        'productions' => $faker->boolean(),
    ];
});