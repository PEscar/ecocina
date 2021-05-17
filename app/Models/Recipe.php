<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'total_cost',
        'extra_cost',
        'quantity',
    ];

    // RELATIONS

    public function product()
    {
    	return $this->belongsTo(Product::class);
    }

    public function lines()
    {
        return $this->belongsToMany(Product::class, 'recipe_line')->withPivot('quantity', 'detail')->withTimestamps();
    }

    // END RELATIONS
}