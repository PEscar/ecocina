<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaleController extends DocumentController
{
	protected $model = 'App\Models\Sale';
	protected $index_view = 'sales';
    protected $form_view = 'forms.sale';
    protected $validation_rules = [
        'qttys.*' => 'required|gt:0',
        'products.*' => 'required|exists:products,id',
        'prices.*' => 'required|gt:0',
        'totals.*' => 'required|gt:0',
        'customer' => 'required',
        'date' => 'required|date',
    ];

    public function getSuccessStoreMessage(Request $request, $id = null)
    {
        $id = $request->route()->parameter('id', \DB::table('sales')->max('id'));
        return 'Venta "#' . $id . '" ' . ( $id ? 'actualizada' : 'creada' ) . ' exitosamente !';
    }
}