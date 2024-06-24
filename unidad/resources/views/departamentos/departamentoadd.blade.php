<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agregar Departamento</title>
</head>
<body>
    <h1>Agregar Departamento</h1>
    <form action="{{ route('departamentos.store') }}" method="POST">
        @csrf
        <div>
            <label for="nombre_departamento">Nombre del Departamento:</label>
            <input type="text" id="nombre_departamento" name="nombre_departamento" required>
        </div>
        <div>   
            <label for="gerente_id">ID del Gerente:</label>
            <input type="number" id="gerente_id" name="gerente_id" required>
        </div>
        <button type="submit">Agregar</button>
    </form>

    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>
