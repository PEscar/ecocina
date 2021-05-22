@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <recipe-list v-bind:product="<?=htmlentities(json_encode($product))?>"></recipe-list>
        </div>
    </div>
</div>
@endsection
