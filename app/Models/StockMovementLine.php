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

	// PERFORMS

	protected function performInsert(Builder $query, array $options = []) {
        parent::performInsert($query, $options);
        $this->updateProductStock();
    }

    protected function performDeleteOnModel() {
        $this->revertStockMovementLine();
        parent::performDeleteOnModel();
    }

	// END PERFORMS

    // METHODS

    public function updateProductStock()
    {
		$this->type == self::STOCK_MOVEMENT_TYPE_IN ? $this->product->inStock($this->quantity) : $this->product->outStock($this->quantity);
    }

    public function revertStockMovementLine()
    {
		$this->type == self::STOCK_MOVEMENT_TYPE_IN ? $this->product->outStock($this->quantity) : $this->product->inStock($this->quantity);
    }

    // END METHOSS
}