<?php

namespace App\Models;

use App\Models\GlobalModel;

class Product extends GlobalModel
{
	const MU_UNIT = 1;
	const MU_KG = 2;
	const MU_LT = 3;
    const MU_M = 4;
    const MU_M2 = 5;

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

    public function updateStock($quantity, $total_cost = 0, $in = true, $update_average_cost = false)
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
                $divisor = ($this->stock + $quantity) > 0 ? $this->stock + $quantity : 1;
                $actual_total_cost = ( $this->average_cost * $this->stock ) + $total_cost;
                $this->average_cost = $actual_total_cost / ( $divisor );
            }
            else
            {
                $divisor = ($this->stock - $quantity) > 0 ? $this->stock - $quantity : 1;
                $actual_total_cost = ( $this->average_cost * $this->stock ) - $total_cost;
                $this->average_cost = $actual_total_cost / ( $divisor );
            }
        }

        $this->stock = $in ? $this->stock + $quantity : $this->stock - $quantity;
        $this->average_cost = $this->stock > 0 ? $this->average_cost : 0;

        return $this;
    }
}