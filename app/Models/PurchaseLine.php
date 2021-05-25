<?php

namespace App\Models;

use App\Models\Purchase;
use App\Models\StockMovementLineGenerator;

class PurchaseLine extends StockMovementLineGenerator
{
	protected $headerModel = 'App\Models\Purchase';
	protected $table = 'purchase_lines';
	public $update_product_average_cost = true;
}
