<?php

namespace App\Models;

use App\Models\StockMovementGenerator;

class PurchaseDeliveryNote extends StockMovementGenerator
{
	protected $lines_table = 'purchase_delivery_note_lines';

	public $stock_movement_type = 'in';
}
