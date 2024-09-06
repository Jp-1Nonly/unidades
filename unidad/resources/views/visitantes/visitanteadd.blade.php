@extends('layout.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Tablero</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('personas.create') }}">Personas</a></li>
                        <li class="breadcrumb-item active">Nuevo</li>
                    </ol>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ingresar datos del nuevo visitante</h3>
                </div>
                <div class="card-body">
                    <div class="form">
                        <form action="{{ route('visitantes.store') }}" method="POST"
                            class="cmxform form-horizontal tasi-form" id="commentForm">
                            @csrf
                            <br>
                            <div class="row align-items-start">
                                <div class="form-group row">
                                    <label for="captura" class="col-form-label col-lg-4">Captura de Foto</label>
                                    <div class="col-lg-8">
                                        <video id="video" width="240" height="160" autoplay></video>
                                        <canvas id="canvas" style="display:none;"></canvas>
                                        <div>
                                            <button type="button" id="takePhoto" class="btn btn-primary btn-xs">Tomar
                                                Foto</button>
                                        </div>
                                        <input type="hidden" id="captura" name="captura"><br>
                                       
                                    </div>
                                </div>
                                <hr>

                                <div class="col-lg-6"> <!-- Columna derecha -->
                                    <div class="form-group row">
                                        <label for="documento" class="col-form-label col-lg-4">Documento</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="documento_visitante" type="text" name="documento_visitante"
                                                   placeholder="Ingresa el documento" aria-required="true" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="form-group row">
                                        <label for="nombre_visitante" class="col-form-label col-lg-4">Nombre</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="nombre_visitante" type="text"
                                                name="nombre_visitante" placeholder="Ingresa el nombre" aria-required="true"
                                                required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="apellido_visitante" class="col-form-label col-lg-4">Apellido</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="apellido_visitante" type="text"
                                                name="apellido_visitante" placeholder="Ingresa el apellido"
                                                aria-required="true" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tipo" class="col-form-label col-lg-4">Descripción</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="id_tipo_visitante" id="tipo" required>
                                                <option value="" disabled selected>Elige un tipo</option>
                                                @foreach ($tipos as $tipo)
                                                    <option value="{{ $tipo['id'] }}">{{ $tipo['descripcion'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>



                            <div class="form-group row mb-0">
                                <div class="offset-lg-2 col-lg-8 text-lg-center">
                                    <button class="btn btn-success btn-xs waves-effect waves-light mr-1" type="button"
                                        id="confirmButton"><i class="mdi mdi-content-save-all"></i> Guardar</button>
                                    <button class="btn btn-danger btn-xs waves-effect" type="button"
                                        onclick="window.location='{{ route('visitantes.index') }}'"><i
                                            class="mdi mdi-close-box-outline"></i> Cancelar</button>
                                </div>
                            </div>
                        </form>

                        @if (session('success'))
                            <div>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <!-- .form -->
                </div>
                <!-- card-body -->
            </div>
            <!-- card -->
        </div>
        <!-- col -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const takePhotoButton = document.getElementById('takePhoto');
            const capturaInput = document.getElementById('captura');

            // Solicitar acceso a la cámara
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then((stream) => {
                    video.srcObject = stream;
                })
                .catch((err) => {
                    console.error("Error al acceder a la cámara: ", err);
                });

            // Capturar la foto
            takePhotoButton.addEventListener('click', function() {
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                // Convertir la imagen capturada a base64
                const dataURL = canvas.toDataURL('image/png');
                capturaInput.value = dataURL; // Guardar en el input oculto

                // Mostrar alerta de éxito
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: '¡Foto tomada!',
                    text: 'exitosamente.',
                    showConfirmButton: false,
                    timer: 1800
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('confirmButton').addEventListener('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    toast: true,
                    title: '¿Está seguro?',
                    text: "¡Desea guardar los datos del visitante!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, guardar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('commentForm').submit();
                    }
                });
            });
        });
    </script>
@endsection
