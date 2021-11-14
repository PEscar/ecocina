@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-center">
                    <h2>
                        Bienvenido a ECocina !
                    </h2>
                </div>
                <div class="card-body">

                    <p>Sistema en etapa de desarrollo.</p>

                    <p>El objetivo del mismo es poder saber exactamente el verdadero coste de producción de un producto, en base a las compras de materias primas realizadas y al proceso de fabricación / elaboración del mismo.</p>

                    <p>Pasos a seguir</p>

                    <ol>
                        <li>Cargar <i>Productos</i> utilizados, ya sea como materia prima/ingrediente o como producto final. Indicar en cada uno de ellos su nombre y unidad de medida.</li>

                        <li>Cargar <i>Recetas</i>. Es como se compone/produce un producto o servicio que vendemos.</li>

                        <li>En este punto, tendras tus productos cargados con stock cero. El siguiente paso, será cargar compras de materia prima, indicando el costo y cantidad de cada producto adquitido. Esto generara existencias de cada producto cargado, y promediara el costo promedio de las existencias previas (si las hay), con las ingresadas recientemente.</li>

                        <li>Una vez tengamos recetas, y materiales suficientes para realizarlas, estaremos en condiciones de <i>producir</i>. Una <i>Producción</i>, consiste en la ejecución, una o más veces, de una determinada receta. Para poder realizar la receta, debemos contar con los ingredientes necesarias.
                        La realización de una receta, restara el stock de los ingredientes consumidos, y sumara el stock al producto elaborado. Esto último, impactará prorrateando en el costo promedio de dicho producto, el costo de la producción actual.</li>

                        <li><i>Gastos</i>, los gastos que no podemos </li>
                    </ol>
                    <!-- <p>Las cuentas gratuitas, disponen de las siguientes funcionalidades</p> -->

                    <!-- <ul>
                        <li>ALTA / BAJA / MODIFICACIÓN  Productos</li>
                        <li>ALTA / BAJA / MODIFICACIÓN  Compras</li>
                        <li>ALTA / BAJA / MODIFICACIÓN  Ventas</li>
                        <li>Control de Stock</li>
                        <li>Regularizaciones de Stock</li>
                    </ul> -->

                    <!-- <a href="bitcoin:bc1q9zlc5j92h0jk5s7m02y9a9ryy0c8tcy6ftjxu9nuu7c6vzcq0w8qx530rt"><img src="{{ url('img/btc_qr.png') }}" alt="BTC QR" height="250" width="250" border="0" /></a>

                    <a href="monero:43kFi9gBv9XG4Vsxe4TEeFaiWVjRWwy9n4KR2A1VaNoZWBQP2gieTro6FKBLPjecNe5DuLXKQyb419UcUop4e3ixNs5n1nE"><img src="{{ url('img/xmr_qr.png') }}" alt="XMR QR" height="250" width="250" border="0" /></a>

                    <a href="litecoin:MWYTQtAVkVhUSfDL5Wgp64LZbtJWyvCTuc"><img src="{{ url('img/ltc_qr.png') }}" alt="LTC QR" height="250" width="250" border="0" /></a>

                    <p>Para donar por otros medios, contactanos por email.</p> -->
            </div>
        </div>
    </div>
</div>
@endsection
