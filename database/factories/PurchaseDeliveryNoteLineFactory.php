<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PurchaseLine;
use Faker\Generator as Faker;

$factory->define(PurchaseLine::class, function (Faker $faker) {

	$qtty = $faker->randomFloat(2, 0, 100);
	$price_per_unit = $faker->randomFloat(2, 0, 100);

    return [
    	'entity_id' => null,
    	'quantity' => $qtty,
    	'price_per_unit' => $price_per_unit,
    	'total' => $qtty * $price_per_unit,
    ];
});