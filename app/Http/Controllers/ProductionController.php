<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Production;
use App\Models\Recipe;
use Illuminate\Http\Request;

class ProductionController extends BaseController
{
    protected $model = 'App\Models\Production';
    protected $index_view = 'productions';
    protected $form_view = 'forms.production';
    protected $validation_rules = [
        'recipe_id' => 'required|exists:recipes,id',
        'recipe_quantity' => 'required',
        'recipe_extra_cost' => 'required',
        'recipe_lines_cost' => 'required',
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

    // public function store(Request $request, $id = null)
    // {
    //     parent::store($request, $id);
        // dd($request->all());
        // parent::store($request, $id);

        // $lines = [];

        // foreach ($request->products as $key => $value) {
        //     $lines[$value] = ['quantity' => $request->qttys[$key], 'detail' => $request->details[$key], 'entity_id' => session('user.entity_id')];
        // }

        // $this->instance->lines()->sync($lines);

        // return redirect($this->index_view);
    // }

    // public function edit($id)
    // {
    //     $recipe = Recipe::with(['lines'])->findOrFail($id);

    //     return view('forms.recipe', ['product' => $recipe->product, 'recipe' => $recipe]);
    // }
}
