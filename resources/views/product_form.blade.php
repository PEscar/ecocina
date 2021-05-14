@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><?= $product ? 'Editar' : 'Nuevo' ?> Producto</div>
                    
                <div class="card-body">
                	<product-form
                		v-bind:edit-product="<?=htmlentities(json_encode($product ? $product : null))?>"
                	></product-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
