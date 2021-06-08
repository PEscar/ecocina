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
    	$update_product_average_cost = $this->parentable->update_product_average_cost; // in case of sale/purchase lines, its a class attribute. in case of stock regularizations / production lines, its recorded on db respective db table
    	$sum = $this->type == 'in';

    	$this->product->updateStock($this->quantity, $this->parentable->total, $sum, $this->parentable->update_product_average_cost);
        $this->product->save();
    }

    public function revertStockMovementLine()
    {
        $update_product_average_cost = $this->parentable->update_product_average_cost; // in case of sale/purchase lines, its a class attribute. in case of stock regularizations / production lines, its recorded on db respective db table
        $sum = $this->type == 'out';

        $this->product->updateStock($this->quantity, $this->parentable->total, $sum, $this->parentable->update_product_average_cost);
        $this->product->save();
    }

    // END METHOSS
}