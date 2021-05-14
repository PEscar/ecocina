<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	const MU_UNIT = 1;
	const MU_KG = 2;
	const MU_LT = 3;

    protected $fillable = [
        'name',
        'detail',
        'sales',
        'shoppings',
        'productions',
        'measure',
    ];
}