<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseController extends BaseController
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

    public function store(Request $request, $id = null)
    {
        parent::store($request, $id);

        $lines = [];

        foreach ($request->products as $key => $value)
        {
            $lines[$value] = [
                'quantity' => $request->qttys[$key],
                'price_per_unit' => $request->prices[$key],
                'total' => $request->totals[$key],
                'entity_id' => session('user.entity_id'),
            ];
        }

        // Delete old lines
        $this->instance->lines()->each(function ($item){
            $item->pivot->delete();
        });

        // Insert new ones
        $this->instance->lines()->attach($lines);

        return redirect('purchases/' . $this->instance->id . '/edit');
    }

    public function getSuccessStoreMessage(Request $request, $id = null)
    {
        $id = $request->route()->parameter('id', \DB::table('purchases')->max('id'));
        return 'Compra "#' . $id . '" ' . ( $id ? 'actualizada' : 'creada' ) . ' exitosamente !';
    }
}