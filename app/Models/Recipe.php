<?php

namespace App\Models;

use App\Models\GlobalModel;

class Recipe extends GlobalModel
{
    protected $fillable = [
        'product_id',
        'extra_cost',
        'quantity',
        'name',
        'detail',
    ];

    // RELATIONS

    public function product()
    {
    	return $this->belongsTo(Product::class);
    }

    public function lines()
    {
        return $this->belongsToMany(Product::class, 'recipe_line')->withPivot('quantity', 'detail', 'entity_id')->withTimestamps();
    }

    // END RELATIONS

    // SCOPES

    public function scopeSearch($query, $search) {
        if(empty($search))
            return;

        $query->where('name', 'like', '%'.$search.'%');
        $query->orWhere('detail', 'like', '%'.$search.'%');
    }

    public function scopeFilters($query, $filters) {

        if ( is_array($filters) )
        {
            foreach ($filters as $key => $value) {

                if ( in_array($key, ['product_id']) )
                {
                    $query->where($key, $value);
                }
            }
        }
    }

    // END SCOPES
}