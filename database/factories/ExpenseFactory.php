<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Expense;
use Faker\Generator as Faker;

$factory->define(Expense::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'date' => $faker->dateTimeThisYear(),
        'total' => $faker->randomFloat(3, 0, 100),
    ];
});