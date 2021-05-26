<?php

namespace App\Http\Controllers;

class ExpenseController extends BaseController
{
    protected $model = 'App\Models\Expense';
    protected $index_view = 'expenses';
    protected $form_view = 'forms.expense';
    protected $validation_rules = [
        'name' => 'required',
        'date' => 'required|date',
        'total' => 'required|gt:0',
    ];

    public function getSuccessStoreMessage($instance)
    {
        return 'Gasto "' . $instance->name . '" ' . ( $instance->wasRecentlyCreated ? 'creado' : 'actualizado' ) . ' exitosamente !';
    }
}
