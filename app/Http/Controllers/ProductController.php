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

    public function getSuccessStoreMessage(Request $request, $id = null)
    {
        return 'Producto "' . $request->name . '" ' . ( $id ? 'actualizado' : 'creado' ) . ' exitosamente !';
    }
}
