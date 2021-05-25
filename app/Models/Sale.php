<?php

namespace App\Models;

use App\Models\SaleLine;
use App\Models\StockMovementGenerator;

class Sale extends StockMovementGenerator
{
	protected $lines_table = 'sale_lines';
	public $stock_movement_type = 'out';

	protected $fillable = [
		'customer',
		'date',
	];

	// RELATIONS
	public function lines()
    {
        return $this->belongsToMany(Product::class, $this->lines_table, 'header_id', 'product_id')->using(SaleLine::class)->withPivot('id', 'quantity', 'price_per_unit', 'total', 'entity_id')->withTimestamps();
    }
	// END RELATIONS

	// SCOPES

    public function scopeSearch($query, $search) {
        $query->where('customer', 'like', '%'.$search.'%');
    }

    // END SCOPES
}
