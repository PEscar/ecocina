<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    protected $model = 'App\Models\Product';
    protected $index_view = 'products';
    protected $form_view = 'forms.product';
    protected $validation_rules = [
        'name' => 'required',
        'detail' => '',
        'sales' => 'min:0|max:1|required_without_all:shoppings,productions',
        'shoppings' => 'min:0|max:1|required_without_all:sales,productions',
        'productions' => 'min:0|max:1|required_without_all:sales,shoppings',
        'measure' => 'required|max:3',
    ];

    public function getSuccessStoreMessage(Request $request, $id = null)
    {
        return 'Producto "' . $request->name . '" ' . ( $id ? 'actualizado' : 'creado' ) . ' exitosamente !';
    }
}
