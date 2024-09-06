@extends('layoutsuse.app')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h5 class="mt-4">Banco de pedidos</h5>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Listado</li>
        </ol>

        <div class="card mb-1">
            <div class="card-body">
                <a class="btn btn-primary btn-sm" href="{{ route('productos.index') }}">Nuevo Pedido</a>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-building-columns yellow_color"></i>
                Listado de pedidos predeterminados
            </div>
            <br>
            <div class="card-body">
                <div class="card-datatable table-responsive">
                    <table id="datatablesSimple" class="datatables-basic table border-top">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Taller</th>
                                <th>Valor</th>
                                <th>Editar</th>
                                <th>PDF</th>
                                <th>Generar</th>
                                <th>Eliminar</th>
                                <th>Add</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $pedido)
                            <tr>
                                <td>{{ $pedido->created_at }}</td>
                                <td>{{ $pedido->taller }}</td>
                                <td>${{ number_format($pedido->total, 0, '.', ',') }}</td>
                                <td><a class="btn btn-primary btn-sm" href="{{ route('editfavorito', $pedido->id) }}"><span class="bi bi-pencil"></span></a></td>
                                <td>
                                    @if (!empty($pedido->profesor->nombre))
                                    <a href="{{ route('pedidos.showfavorito', $pedido->id) }}" class="btn btn-danger btn-sm">
                                        <i class="bi bi-file-pdf"></i>
                                    </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pedidos.clonefavorito', $pedido->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-arrows-turn-right"></i>
                                    </a>
                                </td>
                                <td>
                                    <form id="delete-form-{{ $pedido->id }}" action="{{ route('pedidos.destroyfavorito', $pedido->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $pedido->id }})">
                                        <i class="fa-solid fa-trash-can"></i> 
                                    </button>
                                </td>
                                <td>
                                    
                                    <a class="btn btn-primary btn-sm" href="{{ route('pedidosfavoritos.adicionarfav', $pedido->id) }}">
                                        <i class="fa-solid fa-plus"></i></span>
                                    </a>
                                   
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function confirmDelete(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este pedido?")) {
            event.preventDefault();
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endsection
