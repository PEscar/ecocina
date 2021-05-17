<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
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
    public function index(Request $request)
    {
        $products = Product::orderBy('name', 'asc');

        if ( isset($request->q) && !empty($request->q) )
        {
            $products->search($request->q);
        }
        return json_encode($products->get());
    }

    public function create()
    {
        return view('product_form', ['product' => null ]);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->all());

        return redirect('home')->with('success','Producto "' . $request->name . '" creado exitosamente !');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('product_form', ['product' => new ProductResource($product)]);
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product = $product->update($request->all());

        return redirect('home')->with('success','Producto "' . $request->name . '" actualizado exitosamente !');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        return json_encode($product->delete());
    }
}
