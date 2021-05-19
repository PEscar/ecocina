<?php

namespace App\Http\Controllers;

class PurchaseController extends BaseController
{
	protected $model = 'App\Models\Purchase';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('purchases');
    }
}
