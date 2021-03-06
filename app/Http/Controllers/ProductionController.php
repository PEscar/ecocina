<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Production;
use App\Models\Recipe;
use Illuminate\Http\Request;

class ProductionController extends DocumentController
{
    protected $model = 'App\Models\Production';
    protected $index_view = 'productions';
    protected $form_view = 'forms.production';
    protected $validation_rules = [
        'recipe_id' => 'required|exists:recipes,id',
        'recipe_quantity' => 'required',
        'recipe_extra_cost' => 'required',
        // 'recipe_lines_cost' => 'required',
        'times' => 'required|gt:0',
        'quantity' => 'required',
        'total' => 'required',
    ];

    public function getSuccessStoreMessage($instance)
    {
        return 'Producción #' . $instance->id . ' ' . ( $instance->wasRecentlyCreated ? 'creada' : 'actualizada' ) . ' exitosamente !';
    }

    public function index()
    {
        $recipe = isset($_GET['recipe']) ? Recipe::with('lines')->find($_GET['recipe']) : null;
        $product = !isset($_GET['recipe']) && isset($_GET['product']) ? Recipe::with('lines')->find($_GET['product']) : null;

        return view('productions', ['recipe' => $recipe, 'product' => $product]);
    }

    public function create()
    {
        $recipe = null;
        $product = null;

        if ( isset($_GET['recipe']) && $_GET['recipe'] )
        {
            $recipe = isset($_GET['recipe']) ? Recipe::with(['lines', 'product.recipes.lines'])->find($_GET['recipe']) : null;
            $product = $recipe ? $recipe->product : null;
        }
        else if ( isset($_GET['product']) && $_GET['product'] )
        {
            $product = Product::productions()->with('recipes.lines')->find($_GET['product']);
        }

        return view('forms.production', ['recipe' => $recipe, 'product' => $product]);
    }

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
            'entity_id' => session('user.entity_id'),
            'stock_movement_type' => 'in',
            'update_product_average_cost' => true,
        ];

        return $lines;
    }
}
