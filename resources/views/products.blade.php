@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Productos <a href="{{ url('products/create') }}" class="float-right">Nuevo</a></div>
                    
                <div class="card-body"><product-list></product-list></div>
            </div>
        </div>
    </div>
</div>
@endsection
