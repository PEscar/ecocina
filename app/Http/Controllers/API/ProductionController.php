<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductionController extends DocumentController
{
    protected $model = 'App\Models\Production';
    protected $index_view = 'productions';
    protected $form_view = 'forms.production';
    protected $validation_rules = [
        'recipe_id' => 'required|exists:recipes,id',
        'recipe_quantity' => 'required|numeric|gt:0',
        'recipe_extra_cost' => 'required|numeric',
        'times' => 'required|gt:0|numeric',
        'quantity' => 'required|numeric',
        'total' => 'required|numeric',
        'qttys.*' => 'required|gt:0|numeric',
        'prices.*' => 'required|gt:0|numeric',
        'totals.*' => 'required|gt:0|numeric'
    ];

    protected function fillDocumentLines(Request $request)
    {
        // Get out lines, and set type = out
        $lines = parent::fillDocumentLines($request);

        // Add stock_movement_type = out to all lines
        foreach ($lines as $key => $line) {
            $lines[$key]['stock_movement_type'] = 'out';
            $lines[$key]['update_product_average_cost'] = false;
        }

        // Create line of produced article
        $recipe = Recipe::findOrFail($request->recipe_id);

        // Add line type in
        $lines[$recipe->product->id] = [
            'quantity' => $request->quantity,
            'price_per_unit' => $request->total / $request->quantity,
            'total' => $request->total,
            'entity_id' => $this->model::getUserEntity(),
            'stock_movement_type' => 'in',
            'update_product_average_cost' => true,
        ];

        return $lines;
    }

    public function store(Request $request)
    {
        // Chequeo existencias disponibles de cada producto. Deben ser mayores o iguales que la cantidad necesaria
        foreach ($request->products as $key => $value)
        {
            $product = Product::findOrFail($value);

            if ( $product->stock < $request->qttys[$key] )
                throw ValidationException::withMessages(['product_' . $value . '_stock' => 'Stock insuficiente: ' . $product->name]);
                

        }

        parent::store($request);
    }
}
