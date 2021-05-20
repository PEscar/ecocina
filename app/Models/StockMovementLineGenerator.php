<?php

namespace App\Models;

use App\Interfaces\StockMovementLineGeneratorInterface;
use App\Models\Document;
use App\Models\Purchase;
use App\Models\StockMovementLine;
use Illuminate\Database\Eloquent\Builder;

abstract class StockMovementLineGenerator extends DocumentLine implements StockMovementLineGeneratorInterface
{
	// RELATIONS
    public function stockMovementLine()
    {
        return $this->morphOne(StockMovementLine::class, 'parentable');
    }
    // END RELATIONS

    // PERFORMS

    protected function performInsert(Builder $query, array $options = []) {
        parent::performInsert($query, $options);
        $this->registerStockMovementLine();
    }

    protected function performDeleteOnModel() {
        $this->stockMovementLine->delete();
        parent::performDeleteOnModel();
    }

    public function registerStockMovementLine()
    {
        // Registro moviemiento
        $sml = new StockMovementLine;
        $sml->type = $this->header->stock_movement_type;
        $sml->entity_id = $this->entity_id;
        $sml->stock_movement_id = $this->header->stockMovement->id;
        $sml->product_id = $this->product_id;
        $sml->quantity = $this->quantity;
        $this->stockMovementLine()->save($sml);
    }
    // END PERFORMS
}