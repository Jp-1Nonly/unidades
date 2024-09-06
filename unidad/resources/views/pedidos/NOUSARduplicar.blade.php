@extends('layoutsuse.app')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h5 class="mt-4">pedidos</h5>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Duplicar pedido</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-pencil  orange_color"></i>
                    Duplicar pedido  N°{{ $pedido->id }}
                </div>
                <div class="card-body">

                    <form id="procesarPedidoForm" action="{{ url('/procesar-pedido') }}" method="post">
                @csrf
                @method('POST')


                <div class="form-group">
                    <label for="ficha_id">Nuevo número de Ficha</label>
                        <input class="form-control" id="ficha" name="ficha" type="text"
                         value="{{ $pedido->ficha->ficha }}"   />
                </div>

                  <div class="form-group">
                    <label for="profesor">Nuevo nombre del Instructor</label>
                    <input class="form-control"  name="profesor" id="profesor" type="text"
                         value="{{ $pedido->profesor->nombre }}"   />
                    
                </div> 

            


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
                                    <input type="number" name="productos[{{ $detalle->id }}][cantidad]"
                                        class="form-control" value="{{ $detalle->cantidad }}" step="0.5">

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary"><i class="fa-regular fa-floppy-disk"></i></button>
            </form>
        </div>

        <script>
            // Espera a que el DOM esté completamente cargado
            document.addEventListener('DOMContentLoaded', function() {
                // Selecciona el formulario por su ID
                const form = document.getElementById('editPedidoForm');

                // Agrega un event listener para el evento submit del formulario
                form.addEventListener('submit', function(event) {
                    // Evita que el formulario se envíe de manera predeterminada
                    event.preventDefault();

                    // Envía el formulario utilizando Fetch API o AJAX
                    fetch(form.action, {
                            method: form.method,
                            body: new FormData(form)
                        })
                        .then(response => {
                            if (response.ok) {
                                // Muestra el Sweet Alert cuando la respuesta es exitosa
                                Swal.fire(
                                    '¡Pedido editado correctamente!',
                                    '',
                                    'success'
                                ).then(() => {
                                    // Redirige al usuario a pedidos.index después de cerrar el Sweet Alert
                                    window.location.href = "{{ route('pedidos.index') }}";
                                });
                            } else {
                                // Maneja errores aquí si es necesario
                            }
                        })
                        .catch(error => {
                            console.error('Error al enviar el formulario:', error);
                        });
                });
            });
        </script>
    </main>
    @endsection
