<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PurchaseDeliveryNoteLine;
use Faker\Generator as Faker;

$factory->define(PurchaseDeliveryNoteLine::class, function (Faker $faker) {

	$qtty = $faker->randomFloat(3, 0, 100);
	$price_per_unit = $faker->randomFloat(3, 0, 100);

    return [
    	'entity_id' => null,
    	'quantity' => $qtty,
    	'price_per_unit' => $price_per_unit,
    	'total_cost' => $qtty * $price_per_unit,
    ];
});