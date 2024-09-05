<?php

namespace App\Http\Controllers;

use App\Models\Tipopersona;
use App\Models\Visitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;



class VisitantesController extends Controller
{
    public function index()
    {
        // Consulta SQL personalizada utilizando el constructor de consultas
        $visitantes = DB::select("
            SELECT 
                visitantes.id, 
                visitantes.documento_visitante, 
                visitantes.nombre_visitante, 
                visitantes.apellido_visitante, 
                tipospersonas.descripcion as tipo_descripcion,
                visitantes.captura
            FROM visitantes
            INNER JOIN tipospersonas ON visitantes.id_tipo_visitante = tipospersonas.id
            ORDER BY visitantes.id DESC
        ");

        // Retornar la vista con los datos de los visitantes
        return view('visitantes.index', ['visitantes' => $visitantes]);
    }
    
    
    
    public function store(Request $request)
{
    // Validar los datos
    $request->validate([
        'documento_visitante' => 'required|string',
        'nombre_visitante' => 'required|string',
        'apellido_visitante' => 'required|string',
        'id_tipo_visitante' => 'required|integer',
        'captura' => 'required|string',  // Agregar validación para la captura de foto
    ]);

    // Guardar los datos del visitante
    $visitante = new Visitante();
    $visitante->documento_visitante = $request->input('documento_visitante');
    $visitante->nombre_visitante = $request->input('nombre_visitante');
    $visitante->apellido_visitante = $request->input('apellido_visitante');
    $visitante->id_tipo_visitante = $request->input('id_tipo_visitante');
    
    // Procesar la captura de foto
    if ($request->filled('captura')) {
        $imagenBase64 = $request->input('captura');
        
        // Asegúrate de que el base64 es válido y solo tiene la parte de datos de imagen
        if (strpos($imagenBase64, 'data:image/png;base64,') === 0) {
            $imagenCodificada = str_replace('data:image/png;base64,', '', $imagenBase64);
        } else {
            return redirect()->back()->withErrors(['msg' => 'Formato de imagen no válido.']);
        }

        // Almacena la imagen en formato base64 en el campo 'captura'
        $visitante->captura = $imagenCodificada;
    }

    // Guardar visitante en la base de datos
    $visitante->save();

    return redirect()->route('visitantes.index')->with('success', 'Visitante registrado exitosamente con foto.');
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