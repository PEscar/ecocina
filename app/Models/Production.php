<?php

namespace App\Models;

use App\Models\GlobalModel;
use App\Models\StockMovementLine;
use App\Models\StockMovementGenerator;
use Illuminate\Database\Eloquent\Builder;

class Production extends StockMovementGenerator
{
    public $update_product_average_cost = true;
    protected $lines_table = 'production_lines';

    protected $fillable = [
        'recipe_id',
        'times',
        'recipe_quantity',
        'recipe_extra_cost',
        // 'recipe_lines_cost',
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

    public function lines()
    {
        return $this->belongsToMany(Product::class, $this->lines_table, 'header_id', 'product_id')->using(ProductionLine::class)->withPivot('id', 'stock_movement_type', 'update_product_average_cost', 'quantity', 'price_per_unit', 'total', 'entity_id')->withTimestamps();
    }

    // END RELATIONS

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