<?php

namespace App\Models;

use App\Models\GlobalModel;

class Expense extends GlobalModel
{
    protected $fillable = [
        'name',
        'date',
        'total',
    ];

    // SCOPES

    public function scopeSearch($query, $search) {

        $query->where('name', 'like', '%'.$search.'%');
    }

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