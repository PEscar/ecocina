<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

abstract class DocumentController extends BaseController
{
    public function store(Request $request)
    {
        parent::store($request);

        $lines = $this->fillDocumentLines($request);

        $this->instance->lines()->sync($lines);
        $this->instance->load('lines');

        return response($this->instance, 201);
    }

    public function update(Request $request, $id)
    {
        parent::update($request, $id);

        $lines = $this->fillDocumentLines($request);

        $this->instance->lines()->sync($lines);
        $this->instance->load('lines');

        return response($this->instance, 201);
    }

    protected function fillDocumentLines(Request $request)
    {
        $lines = [];

        foreach ($request->products as $key => $value)
        {
            $lines[$value] = [
                'quantity' => $request->qttys[$key],
                'price_per_unit' => $request->prices[$key],
                'total' => $request->totals[$key],
                'entity_id' => $this->model::getUserEntity(),
            ];
        }

        return $lines;
    }
}