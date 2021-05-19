<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServerTableRequest;

class ServerTableController extends Controller
{
    /**
     * Return data for vue server tables 2.
     *
     */
    public function index(ServerTableRequest $request)
    {
        extract(request()->only(['query', 'limit', 'page', 'model', 'orderBy', 'filters', 'with']));

        $model = 'App\Models\\' . $model;

        $data = $model::select('*');

        if ( isset($query) && !empty($query) )
        {
            $data->search($query);
        }

        if ( isset($filters) && !empty($filters) )
        {
        	$filters = json_decode($filters, true);
            $data->filters($filters);
        }

        $count = $data->count();

        $data->limit($limit)
            ->skip($limit * ($page - 1));

        if ( isset($with) && !empty($with) )
        {
            $data->with($with);
        }

        $results = $data->orderBy($orderBy, 'asc')->get()->toArray();

        return [
            'data' => $results,
            'count' => $count,
        ];
    }
}
