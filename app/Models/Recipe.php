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

    protected $appends = ['lines_cost', 'total_cost'];

    // APPENDS

    public function getLinesCostAttribute()
    {
        $average_costs = $this->lines()->pluck('average_cost');
        $quantities = $this->lines()->pluck('recipe_line.quantity');

        $lines_cost = 0;

        foreach ($average_costs as $key => $average_cost) {
            $lines_cost += $average_cost * $quantities[$key];
        }

        return $lines_cost;
    }

    public function getTotalCostAttribute()
    {
        return $this->lines_cost + $this->extra_cost;
    }

    // END APPENDS

    // RELATIONS

    public function product()
    {
    	return $this->belongsTo(Product::class);
    }

    public function lines()
    {
        return $this->belongsToMany(Product::class, 'recipe_line')->using(RecipeLine::class)->withPivot('quantity', 'detail', 'entity_id')->withTimestamps();
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