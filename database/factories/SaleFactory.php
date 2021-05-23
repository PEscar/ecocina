<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sale;
use Faker\Generator as Faker;

$factory->define(Sale::class, function (Faker $faker) {
    return [
        'customer' => $faker->name,
        'date' => $faker->dateTimeThisYear(),
        'entity_id' => null,
    ];
});