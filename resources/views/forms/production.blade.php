@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Nueva</div>
                    
                <div class="card-body">
                	<production-form
                		v-bind:product="<?=htmlentities(json_encode($product))?>"
                		v-bind:recipe="<?=htmlentities(json_encode($recipe))?>"
                	></production-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
