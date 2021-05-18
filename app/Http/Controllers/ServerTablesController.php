<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Product;

class ServerTablesController extends Controller
{
    /**
     * Return data for vue server tables 2.
     *
     */
    public function index(Request $request)
    {
        extract(request()->only(['query', 'limit', 'page', 'model', 'orderBy', 'filters']));

        if ( !isset($model) )
        {
        	return [
	            'data' => [],
	            'count' => 0,
	        ];
        }

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

        $results = $data->orderBy($orderBy, 'asc')->get()->toArray();

        return [
            'data' => $results,
            'count' => $count,
        ];
    }
}
