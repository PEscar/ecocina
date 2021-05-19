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
        return $this->belongsToMany(Product::class, $this->lines_table, 'header_id', 'product_id')->withPivot('id', 'quantity', 'price_per_unit', 'total', 'entity_id')->withTimestamps();
    }

    // END RELATIONS

    // APPENDS

    protected $appends = ['total'];

    public function getTotalAttribute()
    {
    	return $this->lines()->sum('total');
    }

    // APPENDS
}
