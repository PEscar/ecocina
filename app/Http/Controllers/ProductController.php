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

    public function create()
    {
        return view('product_form', ['product' => null ]);
    }

    public function store(ProductRequest $request, $id = null)
    {
        if ( $id )
        {
            $product = Product::findOrFail($id);
            $product->update($request->all());
        }
        else
        {
            $product = Product::create($request->all());
        }

        return redirect('home')->with('success','Producto "' . $request->name . '" ' . ( $id ? 'actualizado' : 'creado' ) . ' exitosamente !');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('product_form', ['product' => new ProductResource($product)]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        return json_encode($product->delete());
    }
}
