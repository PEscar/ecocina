<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    protected $model = 'App\Models\Product';
    protected $validation_rules = [
        'name' => 'required',
        'detail' => '',
        'sales' => 'min:0|max:1|required_without_all:purchases,productions',
        'purchases' => 'min:0|max:1|required_without_all:sales,productions',
        'productions' => 'min:0|max:1|required_without_all:sales,purchases',
        'measure' => 'required|numeric|max:5',
    ];
}
