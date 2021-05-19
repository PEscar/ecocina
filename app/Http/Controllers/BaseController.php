<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    protected $model = '';
    protected $index_view = '';
    protected $form_view = '';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view($this->index_view);
    }

    public function edit($id)
    {
        $instance = $this->model::findOrFail($id);

        return view($this->form_view, ['instance' => $instance]);
    }

    public function create()
    {
        return view($this->form_view, ['instance' => null]);
    }

    public function store(Request $request, $id = null)
    {
        if ( $id )
        {
            $instance = $this->model::findOrFail($id);
            $instance->update($request->all());
        }
        else
        {
            $instance = $this->model::create($request->all());
        }

        return redirect($this->index_view)->with('success', $this->getSuccessStoreMessage($request));
    }

    public function destroy($id)
    {
        $instance = $this->model::findOrFail($id);
        return json_encode($instance->delete());
    }

    abstract function getSuccessStoreMessage(Request $request, $id = null);
}
