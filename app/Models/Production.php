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

    protected $appends = ['cost_per_unit'];

    // APPENDS

    public function getCostPerUnitAttribute()
    {
        return $this->total / $this->quantity;
    }

    // END APPRENDS

    // RELATIONS

    public function recipe()
    {
    	return $this->belongsTo(Recipe::class);
    }

    public function stockMovement()
    {
        return $this->morphOne(StockMovement::class, 'parentable');
    }

    public function stockMovementLines()
    {
        return $this->morphMany(StockMovementLine::class, 'parentable');
    }

    // END RELATIONS

    // PERFORMS

    protected function performInsert(Builder $query, array $options = []) {
        parent::performInsert($query, $options);
        $this->registerStockMovement();
        $this->registerStockMovementLines();
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

    public function registerStockMovementLines()
    {
        // Register movement IN
        $sml = new StockMovementLine;
        $sml->type = 'in';
        $sml->entity_id = $this->entity_id;
        $sml->stock_movement_id = $this->stockMovement->id;
        $sml->product_id = $this->recipe->product_id;
        $sml->quantity = $this->quantity;
        $this->stockMovementLines()->save($sml);

        // Register moevements OUT
        $this->recipe->lines()->each(function($line){
            $sml = new StockMovementLine;
            $sml->type = 'out';
            $sml->entity_id = $this->entity_id;
            $sml->stock_movement_id = $this->stockMovement->id;
            $sml->product_id = $line->id;
            $sml->quantity = $line->pivot->quantity * $this->times;
            $this->stockMovementLines()->save($sml);
        });
    }

    // END METHODS

    // SCOPES

    public function scopeFilters($query, $filters) {
        if ( is_array($filters) )
        {
            foreach ($filters as $key => $value) {

                $av_filters = ['created_at']; // Available filters

                if ( in_array($key, $av_filters) )
                {
                    switch ($key) {
                        case 'created_at':

                            if ( isset($value['from']) )
                            {
                                // dump(date('Y-m-d 00:00:00', strtotime($value['from'])));
                                $query->where($key, '>=', date('Y-m-d 00:00:00', strtotime($value['from'])));
                            }
                            if ( isset($value['to']) )
                            {
                                // dump(date('Y-m-d 23:59:59', strtotime($value['to'])));
                                $query->where($key, '<=', date('Y-m-d 23:59:59', strtotime($value['to'])));
                            }
                            break;

                        default:
                            $query->where($key, $value);
                            break;
                    }
                }
            }
        }
    }

    // END SOPCES
}