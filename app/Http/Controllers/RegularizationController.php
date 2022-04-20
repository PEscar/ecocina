<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Production;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RegularizationController extends DocumentController
{
    protected $model = 'App\Models\Regularization';
    protected $index_view = 'regularizations';
    protected $form_view = 'forms.regularization';
    protected $validation_rules = [
        'qttys.*' => 'required|gt:0',
        'products.*' => 'required|exists:products,id',
        'types.*' => 'required|in:in,out',
        'update_product_average_cost' => 'required|min:0|max:1',
        'detail' => '',
    ];

    public function getSuccessStoreMessage($instance)
    {
        return 'Regularización #' . $instance->id . ' ' . ( $instance->wasRecentlyCreated ? 'creada' : 'actualizada' ) . ' exitosamente !';
    }

    protected function fillDocumentLines(Request $request)
    {
        $lines = [];

        foreach ($request->products as $key => $value)
        {
            $lines[$value] = [
                'quantity' => $request->qttys[$key],
                'entity_id' => $this->model::getUserEntity(),
                'stock_movement_type' => $request->types[$key],
                'update_product_average_cost' => $request->update_product_average_cost[$key],
            ];
        }

        return $lines;
    }

    // public function store(Request $request, $id = null)
    // {
    //     // dd($request->all());
    //     parent::store($request, $id);

    //     dd('holaaa');
        // dd($request->all());
        // parent::store($request, $id);

        // $lines = [];

        // foreach ($request->products as $key => $value) {
        //     $lines[$value] = ['quantity' => $request->qttys[$key], 'detail' => $request->details[$key], 'entity_id' => session('user.entity_id')];
        // }

        // $this->instance->lines()->sync($lines);

        // return redirect($this->index_view);
    // }

    // public function edit($id)
    // {
    //     $recipe = Recipe::with(['lines'])->findOrFail($id);

    //     return view('forms.recipe', ['product' => $recipe->product, 'recipe' => $recipe]);
    // }
}
