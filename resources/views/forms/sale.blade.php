@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><?= $instance ? 'Editar' : 'Nueva' ?> Venta</div>
                    
                <div class="card-body">
                	<sale-form
                		v-bind:edit-sale="<?=htmlentities(json_encode($instance))?>"
                	></sale-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
