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
        extract(request()->only(['orderBy', 'order', 'model', 'q', 'filters', 'with']));

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

        if ( isset($with) && !empty($with) )
        {
            $data->with($with);
        }

        return json_encode($data->get());
    }
}