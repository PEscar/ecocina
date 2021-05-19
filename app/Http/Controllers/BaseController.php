<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    protected $model = '';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function destroy($id)
    {
        $product = $this->model::findOrFail($id);
        return json_encode($product->delete());
    }
}
