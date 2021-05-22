@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Recetas<a href="{{ url('recipes/create') }}" class="float-right">Nueva</a></div>

                <div class="card-body">
                	<recipe-list
                		v-bind:product="<?=htmlentities(json_encode($product))?>"
                	></recipe-list>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
