<?php

namespace App\Models;

use App\Models\GlobalModel;
use App\Models\StockMovementLine;
use App\Models\StockMovementGenerator;
use Illuminate\Database\Eloquent\Builder;

class Regularization extends StockMovementGenerator
{
    protected $lines_table = 'regularization_lines';

    protected $fillable = [
        'detail'
    ];

    protected $appends = [];

    // RELATIONS

    public function lines()
    {
        return $this->belongsToMany(Product::class, $this->lines_table, 'header_id', 'product_id')->using(RegularizationLine::class)->withPivot('id', 'stock_movement_type', 'update_product_average_cost', 'quantity', 'entity_id')->withTimestamps();
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