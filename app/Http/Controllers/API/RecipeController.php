<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

class RecipeController extends BaseController
{
    protected $model = 'App\Models\Recipe';
    protected $validation_rules = [
        'detail' => '',
        'details,*' => '',
        'extra_cost' => 'gt:0|numeric',
        'name' => 'required',
        'product_id' => 'required|exists:products,id',
        'products.*' => 'required|exists:products,id',
        'qttys.*' => 'required|gt:0|numeric',
        'quantity' => 'required|gt:0|numeric',
    ];

    public function store(Request $request)
    {
        parent::store($request);

        $lines = [];

        foreach ($request->products as $key => $value)
            $lines[$value] = ['quantity' => $request->qttys[$key], 'detail' => isset($request->details[$key]) ? $request->details[$key] : '', 'entity_id' => $this->model::getUserEntity()];

        $this->instance->lines()->sync($lines);
        $this->instance->load('lines');

        return response($this->instance, 201);
    }

    public function update(Request $request, $id)
    {
        parent::update($request, $id);

        $lines = [];

        foreach ($request->products as $key => $value)
            $lines[$value] = ['quantity' => $request->qttys[$key], 'detail' => isset($request->details[$key]) ? $request->details[$key] : '', 'entity_id' => $this->model::getUserEntity()];

        $this->instance->lines()->sync($lines);
        $this->instance->load('lines');

        return response($this->instance, 201);
    }
}
