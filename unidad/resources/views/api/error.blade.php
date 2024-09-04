{{-- resources/views/api/error.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error al Consumir API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Error al Consumir API</h1>
        <div class="alert alert-danger">
            <p>{{ $message }}</p> <!-- Mostrar el mensaje de error pasado desde el controlador -->
        </div>
        <a href="{{ url()->previous() }}" class="btn btn-primary">Volver</a>
    </div>
</body>
</html>
