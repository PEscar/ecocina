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

    protected static $entityField = 'entity_id';

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
}