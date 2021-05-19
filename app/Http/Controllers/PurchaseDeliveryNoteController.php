<?php

namespace App\Http\Controllers;

class PurchaseDeliveryNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('purchasedeliverynotes');
    }
}
