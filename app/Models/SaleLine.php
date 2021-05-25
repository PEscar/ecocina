<?php

namespace App\Models;

use App\Models\StockMovementLineGenerator;

class SaleLine extends StockMovementLineGenerator
{
	protected $headerModel = 'App\Models\Sale';
	protected $table = 'sale_lines';
	public $update_product_average_cost = false;
}
