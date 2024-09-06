@extends('layoutsuse.app')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h5 class="mt-4">Duplicar Pedido N° {{$pedido->id}}</h5>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-copy orange_color"></i>
                NO CAMBIAR DATOS <STRong>SÓLO DAR CLIC EN EL BOTÓN</STRong> - Luego editar
            </div>
            <div class="card-body">
                
                <form action="{{ route('pedidos.clone.store', $pedido->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <h6>Ingrese el nombre del taller</h6>
                        <input class="form-control" type="text" name="taller" value="{{ $pedido->taller }}" required>
                    </div>
                    <div class="form-group">
                        <label for="ficha">Número de Ficha</label>
                        <select class="form-control" id="ficha" name="ficha" readonly>
                            <option value="{{ $pedido->ficha->id }}" selected>{{ $pedido->ficha->ficha }}</option>
                        </select>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="profesor">Instructor</label>

                        <select name="profesor" id="profesor" class="form-control">
                            @foreach ($profesores as $profesor)
                            <option value="{{ $profesor->id }}" {{ $profesor->id == $pedido->profesor_id ? 'selected' : '' }}>{{ $profesor->nombre }} </option> 
                            @endforeach
                            
                        </select>
                    </div>

                                        
                    <div class="form-group">
                        <label for="area">Población</label>
                        <select name="area" id="area" class="form-control">
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}" {{ $area->id == $pedido->area_id ? 'selected' : '' }}>
                                    {{ $area->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="ficha">Observaciones</label>
                        <input class="form-control" id="ficha" name="ficha" type="text" value="{{ $pedido->observaciones }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="ficha">Estado</label>
                        <input class="form-control" id="estado" name="estado" type="text" value="Enviado" readonly>
                    </div>
                   
                    <!-- Agregar la tabla de detalles del pedido aquí -->
                    <h5 class="mt-4">Detalles del Pedido</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detallesPedido as $detalle)
                            <tr>
                                <td>{{ $detalle->producto->nombre }}</td>
                                <td>
                                    <input type="number" name="productos[{{ $detalle->id }}][cantidad]" class="form-control" value="{{ $detalle->cantidad }}" step="0.5" readonly>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Fin de la tabla de detalles del pedido -->
                    <button type="submit" class="btn btn-warning"><i class="fa-regular fa-clone"></i> Duplicar</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection