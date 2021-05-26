<?php

namespace App\Http\Controllers;

class ProductController extends BaseController
{
    protected $model = 'App\Models\Product';
    protected $index_view = 'products';
    protected $form_view = 'forms.product';
    protected $validation_rules = [
        'name' => 'required',
        'detail' => '',
        'sales' => 'min:0|max:1|required_without_all:purchases,productions',
        'purchases' => 'min:0|max:1|required_without_all:sales,productions',
        'productions' => 'min:0|max:1|required_without_all:sales,purchases',
        'measure' => 'required|max:3',
    ];

    public function getSuccessStoreMessage($instance)
    {
        return 'Producto "' . $instance->name . '" ' . ( $instance->wasRecentlyCreated ? 'creado' : 'actualizado' ) . ' exitosamente !';
    }
}
