@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><?= $recipe ? 'Editar' : 'Nueva' ?></strong></div>
                    
                <div class="card-body">
                	<recipe-form
                		v-bind:product="<?=htmlentities(json_encode($product))?>"
                		v-bind:edit-recipe="<?=htmlentities(json_encode($recipe))?>"
                	></recipe-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
