@extends('layoutsuse.app')

@section('content')
<main>
    <h1>Facturados</h1>
    <div class="container-fluid px-4">
        <h5 class="mt-4">Fichas</h5>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Edición</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Editar ficha
            </div>
            <div class="card-body">
                <form id="addFichaForm" action="{{ route('fichas.updated',$fichas->id) }}" method="POST">
                    @csrf
                    <div class="col-md-4 mb-3">
                        <label for="ficha">Número de ficha</label>
                        <input class="form-control" id="ficha" name="ficha" type="text" value="{{$fichas->ficha}}" placeholder="Ingresa el número de la ficha" />
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="nombre">Programa</label>
                        <input class="form-control" id="nombre" name="nombre" type="text"
                            placeholder="Ingresa el programa"  value="{{$fichas->nombre}}"/>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="f_ini">Fecha inicio</label>
                        <input class="form-control" id="f_inicio" name="f_inicio" type="date"
                            placeholder="Ingresa fecha de inicio" value="{{$fichas->f_inicio}}"/>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="f_fin">Fecha fin</label>
                        <input class="form-control" id="f_fin" name="f_fin" type="date"
                            placeholder="Ingresa fecha terminación" value="{{$fichas->f_fin}}"/>
                    </div>
                
                    <div class="mt-4 mb-0">
                        <button class="btn btn-primary" type="submit"><i class="fa-regular fa-floppy-disk"></i></button>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end container -->
</main>

<script>
    // Espera a que el DOM esté completamente cargado
    document.addEventListener('DOMContentLoaded', function () {
        // Selecciona el formulario por su ID
        const form = document.getElementById('addFichaForm');

        // Agrega un event listener para el evento submit del formulario
        form.addEventListener('submit', function (event) {
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
                        '¡Ficha editada exitosamente!',
                        '',
                        'success'
                    ).then(() => {
                        // Redirige al usuario a fichas.index después de cerrar el Sweet Alert
                        window.location.href = "{{ route('fichas.index') }}";
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



@endsection
