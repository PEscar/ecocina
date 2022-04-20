<?php

namespace App\Http\Controllers\API;

class PurchaseController extends DocumentController
{
	protected $model = 'App\Models\Purchase';
	protected $index_view = 'purchases';
    protected $form_view = 'forms.purchase';
    protected $validation_rules = [
        'qttys.*' => 'required|gt:0',
        'products.*' => 'required|exists:products,id',
        'prices.*' => 'required|gt:0',
        'totals.*' => 'required|gt:0',
        'supplier' => 'required',
        'date' => 'required|date',
    ];
}