@extends('layout.app')

@section('content')
<div id="page_pdf">
    <table id="factura_head">
        <tr>
            <td class="logo_factura">
                <div>
                    <img src="{{ asset('img/logo.png') }}" width="70" height="70">
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
                    <p>Nombre: {{ $pedido->taller }}</p>
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
                                <label>Instructor:</label>
                                <p>{{ $pedido->proveedor->nombre }}</p>
                            </td>
                            <td>
                                <label>Documento:</label>
                                <p>{{ $pedido->proveedor->documento }}</p>
                            </td>
                        </tr>
                        <!-- Otras filas de datos del pedido -->
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
                <th class="textright">Precio Total</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @forelse ($pedido->detalles->sortBy('producto_id') as $detalle)
            <tr>
                <td>{{ $detalle->producto_id }}</td>
                <td>{{ optional($detalle->producto)->nombre ?? 'Producto no disponible' }}</td>
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
                    ${{ number_format($detalle->cantidad * optional($detalle->producto)->precio, 0, '.', ',') }}
                </td>
            </tr>
            @php $total += $detalle->cantidad * optional($detalle->producto)->precio; @endphp
            @empty
            <tr>
                <td colspan="6">No hay detalles disponibles</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot id="detalle_totales">
            <tr>
                <td colspan="4"></td>
                <td class="textright">TOTAL:</td>
                <td class="textright"><strong>${{ number_format($total, 0, '.', ',') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="mt-4">
        <a href="{{ route('generate.pdf', ['id' => $pedido->id]) }}" class="btn btn-danger btn-sm" target="_blank">
            <i class="bi bi-file-pdf"></i> PDF
        </a>
    </div>
</div>
@endsection
