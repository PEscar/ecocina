<?php

namespace App\Models;

use App\Models\GlobalModel;
use App\Models\Product;

abstract class Document extends GlobalModel
{
    protected $lines_table = '';

    // RELATIONS
    public function lines()
    {
        return $this->belongsToMany(Product::class, $this->lines_table)->withPivot('quantity', 'price_per_unit', 'total_cost', 'entity_id')->withTimestamps();
    }

    // END RELATIONS

    // APPENDS

    protected $appends = ['total_cost'];

    public function getTotalCostAttribute()
    {
    	return $this->lines()->sum('total_cost');
    }

    // APPENDS
}
