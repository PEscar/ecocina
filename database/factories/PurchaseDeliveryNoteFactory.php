<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Purchase;
use Faker\Generator as Faker;

$factory->define(Purchase::class, function (Faker $faker) {
    return [
    	'supplier' => $faker->name,
    	'date' => $faker->date(),
    	'entity_id' => null,
    ];
});