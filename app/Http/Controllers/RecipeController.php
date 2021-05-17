<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeRequest;
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

    public function store(RecipeRequest $request)
    {
        // $product = Product::create($request->all());

        // return redirect('home')->with('success','Producto "' . $request->name . '" creado exitosamente !');
    }

    public function destroy($product_id, $id)
    {
        $recipe = Product::findOrFail($product_id)->recipes()->where('id', $id)->firstOrFail();
        return json_encode($recipe->delete());
    }
}
