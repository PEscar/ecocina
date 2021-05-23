@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><?= $instance ? 'Editar' : 'Nuevo' ?> Gasto</div>
                    
                <div class="card-body">
                	<expense-form
                		v-bind:edit-expense="<?=htmlentities(json_encode($instance))?>"
                	></expense-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
