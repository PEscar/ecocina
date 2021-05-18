<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($product_id)
    {
        $product = Product::with('recipes.lines')->findOrFail($product_id);

        return view('recipes', ['product' => $product]);
    }

    public function create($product_id)
    {
        $product = Product::findOrFail($product_id);
        return view('recipe_form', ['product' => $product, 'recipe' => null ]);
    }

    public function store($id = null, RecipeRequest $request)
    {
        if ( $id )
        {
            $recipe = Recipe::findOrFail($id);
            $recipe->update($request->except(['product_id']));
        }
        else
        {
            $product = Product::findOrFail($request->product_id);
            $recipe = $product->recipes()->create($request->all());
        }

        $lines = [];

        foreach ($request->products as $key => $value) {
            $lines[$value] = ['quantity' => $request->qttys[$key], 'detail' => $request->details[$key], 'entity_id' => session('user.entity_id')];
        }

        $recipe->lines()->sync($lines);

        return redirect('products/' . $recipe->product_id . '/recipes')->with('success','Receta "' . $recipe->name . '" ' . ( $id ? 'actualizada' : 'creada' ) . ' exitosamente !');
    }

    public function edit($id)
    {
        $recipe = Recipe::with(['lines'])->findOrFail($id);

        return view('recipe_form', ['product' => new ProductResource($recipe->product), 'recipe' => $recipe]);
    }

    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        return json_encode($recipe->delete());
    }
}
