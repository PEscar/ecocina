<?php

namespace App\Models;

use App\Models\Regularization;
use App\Models\StockMovementLineGenerator;

class RegularizationLine extends StockMovementLineGenerator
{
	protected $headerModel = 'App\Models\Regularization';
	protected $table = 'regularization_lines';
}
