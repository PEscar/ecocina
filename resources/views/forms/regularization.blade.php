@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><?= $instance ? 'Editar' : 'Nueva' ?> Regularización</div>
                    
                <div class="card-body">
                	<regularization-form
                		v-bind:edit-purchase="<?=htmlentities(json_encode($instance))?>"
                	></regularization-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
