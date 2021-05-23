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
        if(empty($search))
            return;

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
    // END SCOPES

    // METHODS

    public function inStock($quantity)
    {
        \Log::info('sumando: ' . $quantity);
        $this->stock += $quantity;
        $this->save();

        return $this;
    }

    public function outStock($quantity)
    {
        \Log::info('quitando: ' . $quantity);
        $this->stock -= $quantity;
        $this->save();

        return $this;
    }

    // END METHODS
}