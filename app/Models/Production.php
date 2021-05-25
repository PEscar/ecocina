<?php

namespace App\Models;

use App\Models\GlobalModel;
use App\Models\StockMovementLine;
use Illuminate\Database\Eloquent\Builder;

class Production extends GlobalModel
{
    protected $stock_movement_type = 'in';
    public $update_product_average_cost = true;

    protected $fillable = [
        'recipe_id',
        'times',
        'recipe_quantity',
        'recipe_extra_cost',
        'recipe_lines_cost',
        'quantity',
        'total',
    ];

    // RELATIONS

    public function recipe()
    {
    	return $this->belongsTo(Recipe::class);
    }

    public function stockMovement()
    {
        return $this->morphOne(StockMovement::class, 'parentable');
    }

    public function stockMovementLine()
    {
        return $this->morphOne(StockMovementLine::class, 'parentable');
    }

    // public function lines()
    // {
    //     return $this->belongsToMany(Product::class, 'recipe_line')->withPivot('quantity', 'detail', 'entity_id')->withTimestamps();
    // }

    // END RELATIONS

    // PERFORMS

    protected function performInsert(Builder $query, array $options = []) {
        parent::performInsert($query, $options);
        $this->registerStockMovement();
        $this->registerStockMovementLine();
    }

    protected function performDeleteOnModel() {
        $this->stockMovement->delete();
        parent::performDeleteOnModel();
    }

    // END PERFORMS

    // METHODS

    public function registerStockMovement()
    {
        $sm = new StockMovement;
        $sm->entity_id = $this->entity_id;
        $sm->date = date('Y-m-d');
        $this->stockMovement()->save($sm);
    }

    public function registerStockMovementLine()
    {
        // Registro moviemiento
        $sml = new StockMovementLine;
        $sml->type = $this->stock_movement_type;
        $sml->entity_id = $this->entity_id;
        $sml->stock_movement_id = $this->stockMovement->id;
        $sml->product_id = $this->recipe->product_id;
        $sml->quantity = $this->quantity;
        $this->stockMovementLine()->save($sml);
    }

    // END METHODS
}