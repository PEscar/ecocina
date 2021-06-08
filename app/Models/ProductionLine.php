<?php

namespace App\Models;

use App\Models\StockMovementLineGenerator;

class ProductionLine extends StockMovementLineGenerator
{
	protected $headerModel = 'App\Models\Production';
	protected $table = 'production_lines';
}
