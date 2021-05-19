@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ __('all.purchases') }}<a href="{{ url('purchases/create') }}" class="float-right">{{ __('all.new_female') }}</a></div>

                <div class="card-body">
                	<purchase-list></purchase-list>
               	</div>
            </div>
        </div>
    </div>
</div>
@endsection
