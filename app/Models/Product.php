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