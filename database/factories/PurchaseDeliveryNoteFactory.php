<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PurchaseDeliveryNote;
use Faker\Generator as Faker;

$factory->define(PurchaseDeliveryNote::class, function (Faker $faker) {
    return [
    	'date' => $faker->date(),
    	'entity_id' => null,
    ];
});