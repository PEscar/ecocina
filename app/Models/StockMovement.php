<?php

namespace App\Models;

use App\Models\GlobalModel;

class StockMovement extends GlobalModel
{
	// RELATIONS

	public function parentable()
	{
		return $this->morphTo();
	}

	public function lines()
	{
		return $this->hasMany(StockMovementLine::class);
	}

	// END RELATIONS
}