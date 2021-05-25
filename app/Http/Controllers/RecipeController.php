<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends BaseController
{
    protected $model = 'App\Models\Recipe';
    protected $index_view = 'recipes';
    protected $form_view = 'forms.recipe';
    protected $validation_rules = [
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|gt:0',
        'extra_cost' => '',
        'products.*' => 'required|exists:products,id',
        'qttys.*' => 'required|gt:0',
        'name' => 'required',
        'detial' => '',
    ];

    public function getSuccessStoreMessage(Request $request, $id = null)
    {
        return 'Receta "' . $request->name . '" ' . ( $id ? 'actualizada' : 'creada' ) . ' exitosamente !';
    }

    public function index()
    {
        $product = isset($_GET['product']) ? Product::productions()->with('recipes.lines')->find($_GET['product']) : null;

        return view('recipes', ['product' => $product]);
    }

    public function create()
    {
        $product = isset($_GET['product']) ? Product::productions()->with('recipes.lines')->find($_GET['product']) : null;
        return view('forms.recipe', ['product' => $product, 'recipe' => null ]);
    }

    public function store(Request $request, $id = null)
    {
        parent::store($request, $id);

        $lines = [];

        foreach ($request->products as $key => $value) {
            $lines[$value] = ['quantity' => $request->qttys[$key], 'detail' => $request->details[$key], 'entity_id' => session('user.entity_id')];
        }

        $this->instance->lines()->sync($lines);

        return redirect($this->index_view);
    }

    public function edit($id)
    {
        $recipe = Recipe::with(['lines'])->findOrFail($id);

        return view('forms.recipe', ['product' => $recipe->product, 'recipe' => $recipe]);
    }
}
