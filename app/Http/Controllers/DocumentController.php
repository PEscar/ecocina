<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class DocumentController extends BaseController
{
    public function store(Request $request, $id = null)
    {
        parent::store($request, $id);

        $lines = $this->fillDocumentLines($request);

        // Delete old lines
        $this->instance->lines()->each(function ($item){
            $item->pivot->delete();
        });

        // Insert new ones
        $this->instance->lines()->attach($lines);

        return redirect($this->index_view);
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
                'entity_id' => session('user.entity_id'),
            ];
        }

        return $lines;
    }
}