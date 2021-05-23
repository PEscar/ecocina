<?php

namespace App\Http\Controllers;

use App\Http\Requests\SelectRequest;

class SelectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(SelectRequest $request)
    {
        extract(request()->only(['orderBy', 'order', 'model', 'q', 'filters']));

        $model = 'App\Models\\' . $model;

        $data = $model::orderBy($orderBy, $order);

        if ( isset($request->q) && !empty($request->q) )
        {
            $data->search($request->q);
        }

        if ( isset($filters) && !empty($filters) )
        {
            $data->filters($filters);
        }

        return json_encode($data->get());
    }
}