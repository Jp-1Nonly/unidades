<?php

namespace App\Http\Controllers;

use App\Models\Tipopersona;
use App\Models\Visitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class VisitantesController extends Controller
{
    public function index()
    {
        // Obtener todos los visitantes junto con el tipo de visitante desde la base de datos
        $visitantes = Visitante::join('tipospersonas', 'visitantes.id_tipo_visitante', '=', 'tipospersonas.id')
            ->select('visitantes.*', 'tipospersonas.descripcion as tipo_descripcion') // Selecciona todas las columnas de visitantes y la descripción del tipo
            ->get();
    
        // Retornar la vista con los datos de los visitantes
        return view('visitantes.index', ['visitantes' => $visitantes]);
    }
    
    public function store(Request $request)
{
    // Validación de los datos del formulario
    $validatedData = $request->validate([
        'documento_visitante' => 'required|string|max:20',
        'nombre_visitante' => 'required|string|max:100',
        'apellido_visitante' => 'required|string|max:100',
        'id_tipo_visitante' => 'required|integer',
    ]);

    // Crear un nuevo visitante en la base de datos
    Visitante::create($validatedData);

    // Redireccionar a la vista de index con un mensaje de éxito
    return redirect()->route('visitantes.index')->with('success', 'Visitante agregado con éxito');
}
public function create()
{
    // Obtener los tipos de visitantes de la base de datos
    $tipos = Tipopersona::all();

    // Retornar la vista de creación con los datos necesarios
    return view('visitantes.visitanteadd', [
        'tipos' => $tipos
    ]);
}


    public function show(string $id)
    {
        // Obtener un visitante específico
        $visitante = Visitante::findOrFail($id);

        // Retornar la vista con los detalles del visitante
        return view('visitantes.show', compact('visitante'));
    }

    public function edit(string $id)
    {
        // Obtener el visitante a editar
        $visitante = Visitante::findOrFail($id);

        // Obtener los tipos de visitantes para el formulario de edición
        $tipos = Tipopersona::all();

        // Retornar la vista de edición con los datos del visitante
        return view('visitantes.edit', compact('visitante', 'tipos'));
    }

    public function update(Request $request, string $id)
    {
        // Validación de los datos del formulario
        $request->validate([
            'documento_visitante' => 'required|string|max:20',
            'nombre_visitante' => 'required|string|max:100',
            'apellido_visitante' => 'required|string|max:100',
            'id_tipo_visitante' => 'required|integer',
        ]);

        try {
            // Actualizar el visitante en la base de datos
            $visitante = Visitante::findOrFail($id);
            $visitante->update($request->all());

            // Redireccionar a la vista de index con un mensaje de éxito
            return redirect()->route('visitantes.index')->with('success', 'Visitante actualizado con éxito');
        } catch (\Exception $e) {
            Log::error('Error al actualizar al visitante:', ['error' => $e->getMessage()]);
            return redirect()->route('visitantes.edit', $id)->withErrors('Error al actualizar al visitante');
        }
    }

    public function destroy(string $id)
    {
        try {
            // Eliminar un visitante de la base de datos
            $visitante = Visitante::findOrFail($id);
            $visitante->delete();

            // Redireccionar a la vista de index con un mensaje de éxito
            return redirect()->route('visitantes.index')->with('success', 'Visitante eliminado con éxito');
        } catch (\Exception $e) {
            Log::error('Error al eliminar al visitante:', ['error' => $e->getMessage()]);
            return redirect()->route('visitantes.index')->withErrors('Error al eliminar al visitante');
        }
    }
}