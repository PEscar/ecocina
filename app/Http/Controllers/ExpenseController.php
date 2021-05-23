<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

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

    public function getSuccessStoreMessage(Request $request, $id = null)
    {
        return 'Gasto "' . $request->name . '" ' . ( $id ? 'actualizado' : 'creado' ) . ' exitosamente !';
    }
}
