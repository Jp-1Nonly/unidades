<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Departamento;
use App\Models\Persona;
use App\Models\Tipopersona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PersonasController extends Controller
{
    public function index()
{
    // Obtener todas las personas de la base de datos con los datos del cargo y departamento
    $personas = Persona::select('personas.*', 'cargos.nombre_cargo as cargo_nombre', 'departamentos.nombre_dpto as departamento_nombre')
        ->join('cargos', 'personas.cargo_id', '=', 'cargos.id')
        ->join('departamentos', 'personas.departamento_id', '=', 'departamentos.id')
        ->get();

    // Retornar la vista con los datos de las personas
    return view('personas.index', ['personas' => $personas]);
}


    public function create()
    {
        // Obtener datos necesarios para el formulario de creación
        $tipos = Tipopersona::all();
        $cargos = Cargo::all();
        $dptos = Departamento::all();

        return view('personas.personasadd', [
            'tipos' => $tipos,
            'cargos' => $cargos,
            'dptos' => $dptos
        ]);
    }

    public function store(Request $request)
{
    // Validación de datos de entrada
    $request->validate([
        'documento' => 'required|string|max:255',
        'nombre_persona' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'correo' => 'required|email|max:255',
        'telefono' => 'required|string|max:10', 
        'fecha_contratacion' => 'required|date',
        'cargo_id' => 'required|integer',
        'departamento_id' => 'required|integer',
    ]);

    // Crear una nueva persona en la base de datos utilizando asignación masiva
    Persona::create([
        'documento' => $request->input('documento'),
        'nombre_persona' => $request->input('nombre_persona'),
        'apellido' => $request->input('apellido'),
        'correo' => $request->input('correo'),
        'telefono' => $request->input('telefono'),
        'fecha_contratacion' => Carbon::parse($request->input('fecha_contratacion')),
        'cargo_id' => $request->input('cargo_id'),
        'departamento_id' => $request->input('departamento_id'),
    ]);

    return redirect()->route('personas.index')->with('success', 'Persona agregada con éxito.');
}

    public function show(string $id)
    {
        // Obtener y mostrar una persona específica
        $persona = Persona::findOrFail($id);
        return view('personas.show', compact('persona'));
    }

    public function edit(string $id)
    {
        // Obtener los datos necesarios para editar una persona
        $persona = Persona::findOrFail($id);
        $tipos = Tipopersona::all();
        $cargos = Cargo::all();
        $dptos = Departamento::all();

        return view('personas.edit', compact('persona', 'tipos', 'cargos', 'dptos'));
    }

    public function update(Request $request, string $id)
    {
        // Validación de datos de entrada
        $request->validate([
            'documento' => 'required|string|max:255',
            'nombre_persona' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'telefono' => 'required|string|max:10', 
            'fecha_contratacion' => 'required|date',
            'cargo_id' => 'required|integer',
            'departamento_id' => 'required|integer',
        ]);

        // Actualizar persona en la base de datos
        $persona = Persona::findOrFail($id);
        $persona->documento = $request->input('documento');
        $persona->nombre_persona = $request->input('nombre_persona');
        $persona->apellido = $request->input('apellido');
        $persona->correo = $request->input('correo');
        $persona->telefono = $request->input('telefono');
        $persona->fecha_contratacion = Carbon::parse($request->input('fecha_contratacion'));
        $persona->cargo_id = $request->input('cargo_id');
        $persona->departamento_id = $request->input('departamento_id');
        $persona->save();

        return redirect()->route('personas.index')->with('success', 'Persona actualizada con éxito.');
    }

    public function destroy(string $id)
    {
        // Eliminar una persona de la base de datos
        $persona = Persona::findOrFail($id);
        $persona->delete();

        return redirect()->route('personas.index')->with('success', 'Persona eliminada con éxito.');
    }
}