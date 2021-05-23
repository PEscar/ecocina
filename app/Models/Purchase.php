<?php

namespace App\Models;

use App\Models\PurchaseLine;
use App\Models\StockMovementGenerator;

class Purchase extends StockMovementGenerator
{
	protected $lines_table = 'purchase_lines';

	public $stock_movement_type = 'in';

	protected $fillable = [
		'supplier',
		'date',
	];

	// RELATIONS
	public function lines()
    {
        return $this->belongsToMany(Product::class, $this->lines_table, 'header_id', 'product_id')->using(PurchaseLine::class)->withPivot('id', 'quantity', 'price_per_unit', 'total', 'entity_id')->withTimestamps();
    }
	// END RELATIONS

	// SCOPES

    public function scopeSearch($query, $search) {
        $query->where('supplier', 'like', '%'.$search.'%');
    }

    // END SCOPES
}
