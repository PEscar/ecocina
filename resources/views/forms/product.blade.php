@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><?= $instance ? 'Editar' : 'Nuevo' ?> Producto</div>
                    
                <div class="card-body">
                	<product-form
                		v-bind:edit-product="<?=htmlentities(json_encode($instance))?>"
                	></product-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
