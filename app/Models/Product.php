<?php

namespace App\Models;

use App\Models\GlobalModel;

class Product extends GlobalModel
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

    // RELATIONS

    public function recipes()
    {
		return $this->hasMany(Recipe::class);
    }

    // END RELATIONS

    // SCOPES

    public function scopeSearch($query, $search) {
        if(empty($search))
            return;

        $query->where('name', 'like', '%'.$search.'%');
        $query->orWhere('detail', 'like', '%'.$search.'%');
    }

    // END SCOPES

    // METHODS

    public function inStock($quantity)
    {
        \Log::info('sumando: ' . $quantity);
        $this->stock += $quantity;
        $this->save();

        return $this;
    }

    public function outStock($quantity)
    {
        \Log::info('quitando: ' . $quantity);
        $this->stock -= $quantity;
        $this->save();

        return $this;
    }

    // END METHODS
}