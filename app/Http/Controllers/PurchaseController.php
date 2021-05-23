<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function getSuccessStoreMessage(Request $request, $id = null)
    {
        $id = $request->route()->parameter('id', \DB::table('purchases')->max('id'));
        return 'Compra "#' . $id . '" ' . ( $id ? 'actualizada' : 'creada' ) . ' exitosamente !';
    }
}