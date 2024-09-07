@extends('layoutsuse.app')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h5 class="mt-4">pedidos</h5>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Editar pedido</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-pencil  orange_color"></i>
                Editar pedido N° {{ $pedido->id }}
            </div>
            <div class="card-body">

                <form id="editPedidoForm" action="{{ route('pedidos.update', $pedido->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <div class="mt-4">
                            <h6>Ingrese el nombre del taller</h6>
                            <input class="form-control" type="text" name="taller" value="{{ $pedido->taller }}" required>
                        </div>

                      
                    </div>

                        <div class="form-group">
                            <label for="profesor"><h6>Nombre del Instructor</h6></label>
                            <select name="profesor" id="profesor" class="form-control">
                                @foreach ($profesores as $profesor)
                                <option value="{{ $profesor->id }}" {{ $profesor->id == $pedido->profesor_id ? 'selected' : '' }}>{{ $profesor->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="area_id"><h6>Población</h6></label>
                            <select class="form-control" id="area_id" name="area_id">
                                @foreach($areas as $area)
                                <option value="{{ $area->id }}" {{ $pedido->area_id == $area->id ? 'selected' : '' }}>
                                    {{ $area->nombre }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="estado"><h6>Estado del pedido</h6></label>
                            <input class="form-control" type="text" name="estado" value="Enviado">
                        </div>

                        <div class="mt-4">
                            <h6>Observaciones</h6>
                            <input class="form-control" type="text" name="observaciones" value="{{ $pedido->observaciones }}">
                        </div>

                        <h5 class="mt-4">Detalles del Pedido</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detallesPedido as $detalle)
                                <tr>
                                    <td>{{ $detalle->producto->id }}</td>
                                    <td>{{ $detalle->producto->nombre }}</td>
                                    <td>
                                        <input type="number" name="productos[{{ $detalle->id }}][cantidad]" class="form-control" value="{{ $detalle->cantidad }}" step="0.1" min="0">
                                    </td>
                                    <td>
                                        <a href="{{ route('detallepedidos.delete', ['id' => $detalle->id]) }}" class="btn btn-danger">
                                            <i class="fa-solid fa-trash-can"></i> 
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary"><i class="fa-regular fa-floppy-disk"></i> Guardar</button>
                </form>
            </div>


        </div>
    </div>
</main>
@endsection