<?php

namespace App\Models;

use App\Models\PurchaseDeliveryNote;
use App\Models\StockMovementLineGenerator;

class PurchaseDeliveryNoteLine extends StockMovementLineGenerator
{
	protected $headerModel = 'App\Models\PurchaseDeliveryNote';
}
