@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body text-center">

                    <h2>
                        Bienvenido a ECocina !
                    </h2>

                    <p>Sistema en etapa de desarrollo.</p>

                    <p>El objetivo del mismo es poder saber a ciencia cierta el verdadero coste de producción de un producto, en base a las compras de materias primas realizadas y al proceso de fabricación / elaboración del producto.</p>

                    <p>Las cuentas gratuitas, disponen de las siguientes funcionalidades</p>

                    <ul>
                        <li>ALTA / BAJA / MODIFICACIÓN  Productos</li>
                        <li>ALTA / BAJA / MODIFICACIÓN  Compras</li>
                        <li>ALTA / BAJA / MODIFICACIÓN  Ventas</li>
                        <li>Control de Stock</li>
                        <li>Regularizaciones de Stock</li>
                    </ul>

                    <a href="bitcoin:bc1q9zlc5j92h0jk5s7m02y9a9ryy0c8tcy6ftjxu9nuu7c6vzcq0w8qx530rt"><img src="{{ url('img/btc_qr.png') }}" alt="Bitcoin QR Code Generator" height="300" width="300" border="0" /></a>

                    <p>Para donar por otros medios, contactanos por email.</p>
            </div>
        </div>
    </div>
</div>
@endsection
