<?php

namespace App\Models;

use App\Interfaces\StockMovementGeneratorInterface;
use App\Models\Document;
use App\Models\StockMovement;
use App\Models\StockMovementLine;
use Illuminate\Database\Eloquent\Builder;

abstract class StockMovementGenerator extends Document implements StockMovementGeneratorInterface
{
	// RELATIONS
    public function stockMovement()
    {
        return $this->morphOne(StockMovement::class, 'parentable');
    }
    // END RELATIONS

    // PERFORMS

    protected function performInsert(Builder $query, array $options = []) {
        parent::performInsert($query, $options);
        $this->registerStockMovement();
    }

    protected function performDeleteOnModel() {
        dump('performDeleteOnModel StockMovementGenerator');
        \Log::info('performDeleteOnModel StockMovementGenerator');
        $this->stockMovement->delete();
        parent::performDeleteOnModel();
    }

    public function registerStockMovement()
    {
    	$sm = new StockMovement;
    	$sm->entity_id = $this->entity_id;
    	$sm->date = date('Y-m-d');
    	$this->stockMovement()->save($sm);
    }
    // END PERFORMS
}