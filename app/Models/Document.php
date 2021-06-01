<?php

namespace App\Models;

use App\Models\GlobalModel;
use App\Models\Product;

abstract class Document extends GlobalModel
{
    protected $lines_table = '';

    // RELATIONS
    public function lines()
    {
        return $this->belongsToMany(Product::class, $this->lines_table, 'header_id', 'product_id')->withPivot('id', 'quantity', 'price_per_unit', 'total', 'entity_id')->withTimestamps();
    }

    // END RELATIONS

    // APPENDS

    protected $appends = ['total'];

    public function getTotalAttribute()
    {
    	return $this->lines()->sum('total');
    }

    // END APPENDS

    // SCOPES

    public function scopeFilters($query, $filters) {
        if ( is_array($filters) )
        {
            foreach ($filters as $key => $value) {

                $av_filters = ['date']; // Available filters

                if ( in_array($key, $av_filters) )
                {
                    switch ($key) {
                        case 'date':

                            if ( isset($value['from']) )
                            {
                                $query->where($key, '>=', date('Y-m-d', strtotime($value['from'])));
                            }
                            if ( isset($value['to']) )
                            {
                                $query->where($key, '<=', date('Y-m-d', strtotime($value['to'])));
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

    // END SCOPES
}
