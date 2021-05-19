<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseController extends BaseController
{
	protected $model = 'App\Models\Purchase';
	protected $index_view = 'purchases';
    protected $form_view = 'forms.purchase';

    public function getSuccessStoreMessage(Request $request, $id = null)
    {
        return 'Compra "' . $request->name . '" ' . ( $id ? 'actualizada' : 'creada' ) . ' exitosamente !';
    }
}