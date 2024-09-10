@extends('layout.app')

@section('content')
    <!DOCTYPE html>
    <html class="no-js" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="ThemeMarch">
        <title>General Invoice</title>
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    </head>

    <body>
        <div class="cs-container">
            <div class="cs-invoice cs-style1">
                <div class="cs-invoice_in" id="download_section">
                    <div class="cs-invoice_head cs-type1 cs-mb25">
                        <div class="cs-invoice_left">
                            <p class="cs-invoice_number cs-primary_color cs-mb5 cs-f16"><b class="cs-primary_color">Pedido
                                    No:</b> {{ $pedido->id }}</< /p>
                            <p class="cs-invoice_date cs-primary_color cs-m0"><b class="cs-primary_color">Fecha:
                                </b>{{ $pedido->created_at->format('Y-m-d') }}</p>
                        </div>
                        <div class="cs-invoice_right cs-text_right">
                            <div class="cs-logo cs-mb5"><img src="{{ asset('assets/img/logo.jpg') }}" alt="Logo"></div>
                        </div>
                    </div>
                    <div class="cs-invoice_head cs-mb10">
                        <div class="cs-invoice_left">
                            <b class="cs-primary_color">Solicita: </b>
                            <p>
                                {{ $datos->realiza }} <br>
                                {{ $datos->telefono }}<br>{{ $datos->correo }}</<br>
                            </p>
                        </div>
                        <div class="cs-invoice_right cs-text_right">
                            <b class="cs-primary_color">Proveedor:</b>
                            <p>
                                {{ $pedido->proveedor->nombre }} <br>
                                {{ $pedido->proveedor->celular }}<br>
                                {{ $pedido->proveedor->correo }}
                            </p>
                        </div>
                    </div>
                    <div class="cs-table cs-style1">
                        <div class="cs-round_border">
                            <div class="cs-table_responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Item</th>
                                            <th class="cs-width_4 cs-semi_bold cs-primary_color cs-focus_bg">Description
                                            </th>
                                            <th class="cs-width_2 cs-semi_bold cs-primary_color cs-focus_bg">Medida</th>
                                            <th class="cs-width_1 cs-semi_bold cs-primary_color cs-focus_bg">Cantidad</th>
                                            <th class="cs-width_2 cs-semi_bold cs-primary_color cs-focus_bg cs-text_right">
                                                Precio un.</th>
                                            <th class="cs-width_2 cs-semi_bold cs-primary_color cs-focus_bg cs-text_right">
                                                Total</th>
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
                                                <td class="textright">{{ $detalle->cantidad }}</td>
                                                <td class="textright">
                                                    @if ($detalle->producto)
                                                        ${{ number_format($detalle->producto->precio, 0, '.', ',') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="textright">
                                                    ${{ number_format($detalle->cantidad * $detalle->producto->precio, 0, '.', ',') }}
                                                </td>
                                            </tr>
                                            <?php $total = $total + $detalle->cantidad * $detalle->producto->precio; ?>

                                        @empty
                                            <tr>
                                                <td colspan="4">No hay detalles disponibles</td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div><hr>
                            <div class="cs-invoice_footer cs-border_top" style="display: flex; justify-content: space-between; align-items: center;">
                                <!-- Observaciones -->
                                <div class="cs-left_footer" style="flex: 1; margin-right: 20px;">
                                    <p class="cs-mb0"><b class="cs-primary_color">Observaciones:</b></p>
                                    <p class="cs-m0">{{ $pedido->observaciones }}</p>
                                </div>
                            
                                <!-- Total -->
                                <div class="cs-right_footer" style="flex: 1; text-align: right;">
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <tbody>
                                            <tr>
                                                <td class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Total</td>
                                                <td class="cs-width_3 cs-semi_bold cs-focus_bg cs-primary_color cs-text_right">
                                                    $<?php echo number_format($total, 0, '.', ','); ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                      
                    </div>
                   
                </div>
                <div class="cs-invoice_btns cs-hide_print">
                    <a href="javascript:window.print()" class="cs-invoice_btn cs-color1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                            <path
                                d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24"
                                fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                            <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none"
                                stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                            <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none"
                                stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                            <circle cx="392" cy="184" r="24" />
                        </svg>
                        <span>Print</span>
                    </a>
                    
                </div>
            </div>
        </div>

    </body>

    </html>
@endsection
