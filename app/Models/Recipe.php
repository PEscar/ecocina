<?php

namespace App\Models;

use App\Models\GlobalModel;

class Recipe extends GlobalModel
{
    protected $fillable = [
        'extra_cost',
        'quantity',
        'name',
        'detail',
    ];

    protected static $entityField = 'entity_id';

    // RELATIONS

    public function product()
    {
    	return $this->belongsTo(Product::class);
    }

    public function lines()
    {
        return $this->belongsToMany(Product::class, 'recipe_line')->withPivot('quantity', 'detail', 'entity_id')->withTimestamps();
    }

    // END RELATIONS
}