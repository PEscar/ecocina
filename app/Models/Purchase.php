<?php

namespace App\Models;

use App\Models\StockMovementGenerator;

class Purchase extends StockMovementGenerator
{
	protected $lines_table = 'purchase_lines';

	public $stock_movement_type = 'in';

	protected $fillable = [
		'supplier'
	];
}
