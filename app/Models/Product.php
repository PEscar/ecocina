<?php

namespace App\Models;

use App\Models\GlobalModel;

class Product extends GlobalModel
{
	const MU_UNIT = 1;
	const MU_KG = 2;
	const MU_LT = 3;

    protected $fillable = [
        'name',
        'detail',
        'sales',
        'purchases',
        'productions',
        'measure',
    ];

    // RELATIONS

    public function recipes()
    {
		return $this->hasMany(Recipe::class);
    }

    // public function purchasLines()
    // {
    //     return $this->hasMany(PurchaseLine::class, 'purchase_lines', 'product_id')->withPivot('id', 'quantity', 'price_per_unit', 'total', 'entity_id')->withTimestamps();
    // }

    public function lines()
    {
        $purchase_lines = $this->belongsToMany(Purchase::class, 'purchase_lines', 'product_id', 'header_id')->withPivot('id', 'quantity', 'price_per_unit', 'total', 'entity_id')->withTimestamps();

        // $recipe_lines = $this->belongsToMany(Recipe::class, 'recipe_line')->withPivot('quantity', 'detail', 'entity_id')->withTimestamps();

        return $purchase_lines;
    }

    // END RELATIONS

    // SCOPES

    public function scopeSearch($query, $search) {
        $query->where('name', 'like', '%'.$search.'%');
        $query->orWhere('detail', 'like', '%'.$search.'%');
    }

    public function scopeFilters($query, $filters) {

        if ( is_array($filters) )
        {
            foreach ($filters as $key => $value) {

                if ( in_array($key, ['purchases', 'sales', 'productions']) )
                {
                    $query->where($key, $value);
                }
            }
        }
    }

    public function scopeProductions($query)
    {
        return $query->where('productions', 1);
    }

    public function scopeSales($query)
    {
        return $query->where('sales', 1);
    }

    public function scopePurchases($query)
    {
        return $query->where('purchases', 1);
    }

    // END SCOPES

    // METHODS

    public function updateStock($quantity, $total_cost, $in = true, $update_average_cost = false)
    {
        // dump('stock precio: ' . $this->stock);
        // dump('promedio viejo: ' . $this->average_cost);

        // dump('quantity: ' . $quantity);
        // dump('total_cost: ' . $total_cost);
        // dump('in: ' . $in);
        // dump('update_average_cost: ' . $update_average_cost);

        if ($update_average_cost)
        {
            if ( $in )
            {
                $actual_total_cost = ( $this->average_cost * $this->stock ) + $total_cost;
                $this->average_cost = $actual_total_cost / ( $this->stock + $quantity );
            }
            else
            {
                $actual_total_cost = ( $this->average_cost * $this->stock ) - $total_cost;
                $this->average_cost = $actual_total_cost / ( $this->stock - $quantity );
            }
        }

        $this->stock = $in ? $this->stock + $quantity : $this->stock - $quantity;
        $this->save();

        return $this;
    }
}