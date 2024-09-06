<!-- resources/views/pedidos/show.blade.php -->

@extends('layoutsuse.app')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <style>
        @import url('{{asset(' fonts/BrixSansRegular.css')}}');
        @import url('{{asset(' fonts/BrixSansBlack.css')}}');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        p,
        label,
        span,
        table {
            font-family: 'Verdana';
            font-size: 9pt;
        }

        .h2 {
            font-family: 'BrixSansBlack';
            font-size: 16pt;
        }

        .h3 {
            font-family: 'BrixSansBlack';
            font-size: 12pt;
            display: block;
            background: #0a4661;
            color: #FFF;
            text-align: center;
            padding: 3px;
            margin-bottom: 5px;
        }

        #page_pdf {
            width: 95%;
            margin: 15px auto 10px auto;
        }

        #factura_head,
        #factura_cliente,
        #factura_detalle {
            width: 100%;
            margin-bottom: 10px;
        }

        .logo_factura {
            width: 25%;
        }

        .info_empresa {
            width: 50%;
            text-align: center;
        }

        .info_factura {
            width: 25%;
        }

        .info_cliente {
            width: 100%;
        }

        .datos_cliente {
            width: 100%;
        }

        .datos_cliente tr td {
            width: 50%;
        }

        .datos_cliente {
            padding: 10px 10px 0 10px;
        }

        .datos_cliente label {
            width: 75px;
            display: inline-block;
        }

        .datos_cliente p {
            display: inline-block;
        }

        .textright {
            text-align: right;
        }

        .textleft {
            text-align: left;
        }

        .textcenter {
            text-align: center;
        }

        .round {
            border-radius: 10px;
            border: 1px solid #0a4661;
            overflow: hidden;
            padding-bottom: 15px;
        }

        .round p {
            padding: 0 15px;
        }

        #factura_detalle {
            border-collapse: collapse;
        }

        #factura_detalle thead th {
            background: #058167;
            color: #FFF;
            padding: 5px;
        }

        #detalle_productos tr:nth-child(even) {
            background: #ededed;
        }

        #detalle_totales span {
            font-family: 'BrixSansBlack';
        }

        .nota {
            font-size: 8pt;
        }

        .label_gracias {
            font-family: verdana;
            font-weight: bold;
            font-style: italic;
            text-align: center;
            margin-top: 20px;
        }

        .anulada {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translateX(-50%) translateY(-50%);
        }
    </style>

</head>

<body>

    <div id="page_pdf">
        <table id="factura_head">
            <tr>
                <td class="logo_factura">
                    <div>
                        <img src="{{asset('img/logo.png')}}" width="70" height="70">
                    </div>
                </td>


                <td class="info_empresa">
                    <div>
                        <span class="h2">{{ $datos->sigla }}</span>
                        <p>{{ $datos->nombre }}</p>
                        <p>Teléfono: {{ $datos->telefono }}</p>
                        <p>Correo: {{ $datos->correo }}</p>
                    </div>
                </td>
                <td class="info_factura">
                    <div class="round">
                        <span class="h3">Pedido</span>
                        <p>N°: No aplica</p>
                        <p>Fecha: {{ $pedido->created_at->format('Y-m-d') }}</p>
                        <p>Hora: {{ $pedido->created_at->format('H:i') }}</p>
                        <p>Realizó: {{ $datos->realiza }}</p>
                    </div>
                </td>
            </tr>
        </table>
        <table id="factura_cliente">
            <tr>
                <td class="info_cliente">
                    <div class="round">
                        <span class="h3">Datos del pedido (Banco de pedidos)</span>
                        <table class="datos_cliente">
                            <tr>
                                <td>
                                    <label>Taller:</label>
                                    <p>{{ $pedido->taller }}</p>
                                </td>
                        </table>
                    </div>
                </td>

            </tr>
        </table>

        <table id="factura_detalle">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Descripción</th>
                    <th>Unidad de medida</th>
                    <th class="textright">Cantidad</th>
                    <th class="textright">Precio Unitario</th>
                    <th class="textright"> Precio Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                @php
                $detallesOrdenados = $pedido->detalles->sortBy('producto_id');
                @endphp
                @forelse ($pedido->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto_id }}</td>
                    <td>
                        @if ($detalle->producto)
                        {{ $detalle->producto->nombre }}
                        @else
                        Producto no disponible
                        @endif
                    </td>
                    <td>{{ optional($detalle->producto)->medida ?? 'N/A' }}</td>
                    <td  class="textright">{{ $detalle->cantidad }}</td>
                    <td  class="textright">
                        @if ($detalle->producto)
                        ${{ number_format($detalle->producto->precio, 0, '.', ',') }}
                        @else
                        N/A
                        @endif
                    </td>
                    <td class="textright">${{ number_format($detalle->cantidad*$detalle->producto->precio, 0, '.', ',')}}</td>
                </tr>
                <?php $total = $total + ($detalle->cantidad * $detalle->producto->precio); ?>

                @empty
                <tr>
                    <td colspan="4">No hay detalles disponibles</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot id="detalle_totales">

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td  class="textright">TOTAL:</td>
                    <td  class="textright"><strong>$<?php echo number_format($total, 0, '.', ','); ?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="mt-4">

        <a href="{{ route('pedidos.indexfavoritos') }}" class="btn btn-danger btn-sm">Ir Atras</a>
    </div>




</body>

</html>





@endsection