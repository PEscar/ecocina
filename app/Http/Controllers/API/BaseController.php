<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $model = '';
    protected $instance_id = '';
    protected $validation_rules = [];

    public function index()
    {
        return response($this->model::all());
    }

    public function show($id)
    {
        return response($this->model::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $instance = $this->model::findOrFail($id);
        $instance->update($request->all());
        return response($instance->refresh());
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        return response($this->model::create($request->all()));
    }

    public function destroy($id)
    {
        $this->model::findOrFail($id)->delete();
        return response()->noContent();
    }

    public function validateRequest(Request $request)
    {
        $request->validate($this->validation_rules);
    }
}