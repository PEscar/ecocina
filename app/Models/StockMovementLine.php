<?php

namespace App\Models;

use App\Models\GlobalModel;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class StockMovementLine extends GlobalModel
{
	const STOCK_MOVEMENT_TYPE_IN = 'in';
	const STOCK_MOVEMENT_TYPE_OUT = 'out';

	// RELATIONS

	public function parentable()
	{
		return $this->morphTo();
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	// END RELATIONS

	// INSERT

	protected function performInsert(Builder $query, array $options = []) {
        parent::performInsert($query, $options);
        $this->updateProductStock();
    }

	// END INSERT

    // METHODS

    public function updateProductStock()
    {
		$this->type == self::STOCK_MOVEMENT_TYPE_IN ? $this->product->inStock($this->quantity) : $this->product->outStock($this->quantity);
    }

    // END METHOSS
}