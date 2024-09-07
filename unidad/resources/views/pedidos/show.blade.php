<!-- resources/views/pedidos/show.blade.php -->

@extends('layout.app')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <style>
     

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
                        <p>N°: <strong>{{ $pedido->id }}</strong></p>
                      
                        <p>Fecha: {{ $pedido->created_at->format('Y-m-d') }}</p>
                        <p>Realizó: {{ $datos->realiza }}</p>
                    </div>
                </td>
            </tr>
        </table>
        <table id="factura_cliente">
            <tr>
                <td class="info_cliente">
                    <div class="round">
                        <span class="h3">Datos del pedido</span>
                        <table class="datos_cliente">
                            <tr>
                                <td>
                                    <label>Proveedor:</label>
                                    <p>{{ $pedido->proveedor->nombre }}</p>
                                </td>
                                <td>
                                    <label>Nit:</label>
                                    <p>{{ $pedido->proveedor->documento }}</p>
                                </td>
                            </tr>
                            
                            
                           
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
        <div>
            <br>
            <p>Observaciones:</p>
            <table id="factura_cliente">
                <tr>
                    <td class="">
                        <div class="round">
                            <table class="datos_cliente">
                                <tr>
                                    <td><p>{{ $pedido->observaciones }}</p></td> 
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

            <br>
            <p>Aceptación del pedido:</p>
            <table id="factura_cliente">
                <tr>
                    <td class="">
                        <div class="round">

                            <table class="datos_cliente">
                                <tr>
                                    <td><label>Administrador</label></td>
                                    <td><label>Revisor</label></td>
                                    <td><label></label></td>
                                </tr>
                                <tr>
                                    <td>_______________</td>
                                    <td>_______________</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </td>

                </tr>
            </table>

        </div>

    </div>
    <div class="mt-4">

        <a href="{{ route('generate.pdf', ['id' => $pedido->id]) }}" class="btn btn-danger btn-sm" target="_blank"><i class="bi bi-file-pdf"></i> PDF</a>
    </div>

</body>

</html>
<br>
<br>
@endsection