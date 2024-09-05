<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use App\Models\Visitante;
use App\Models\Residente;
use App\Models\Tipopersona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class VisitasController extends Controller
{
    public function index()
    {
        // Consulta SQL personalizada utilizando el constructor de consultas
        $visitas = DB::select("
            SELECT 
                visitas.id,  -- Seleccionar el campo 'id' de la tabla 'visitas'
                visitantes.documento_visitante, 
                visitantes.nombre_visitante, 
                visitantes.apellido_visitante,  -- Asegurarse de que este campo está seleccionado
                residentes.nombre, 
                residentes.apellido, 
                residentes.apartamento,  -- Asegúrate de incluir este campo
                visitas.motivo_visita, 
                visitas.vehiculo, 
                visitas.fecha_ingreso, 
                visitas.fecha_salida 
            FROM visitas 
            INNER JOIN visitantes ON visitas.visitante_id = visitantes.id
            INNER JOIN residentes ON visitas.residente_id = residentes.id
            ORDER BY visitas.id DESC
        ");
    
        // Retornar la vista con los datos de las visitas
        return view('visitas.index', ['visitas' => $visitas]);
    }
    


    public function edit($id)
    {
        // Obtener los detalles de la visita
        $visita = Visita::findOrFail($id);

        // Obtener la lista de todos los visitantes y residentes
        $visitantes = Visitante::all();
        $residentes = Residente::all();

        return view('visitas.visitasedit', [
            'visita' => $visita,
            'visitantes' => $visitantes,
            'residentes' => $residentes
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'visitante_id' => 'required|integer|exists:visitantes,id',
            'residente_id' => 'required|integer|exists:residentes,id',
            'motivo_visita' => 'required|string|max:255',
            'vehiculo' => 'nullable|string|max:10',
            'fecha_ingreso' => 'required|date',
        ]);
    
        try {
            // Encontrar la visita por ID
            $visita = Visita::findOrFail($id);
    
            // Establecer la fecha y hora de salida actual en la zona horaria de Bogotá
            $visita->fecha_salida = now('America/Bogota');
    
            // Actualizar la visita en la base de datos
            $visita->update($validatedData + ['fecha_salida' => $visita->fecha_salida]);
    
            return redirect()->route('visitas.index')->with('success', 'Hora de salida asignada con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar la visita:', ['error' => $e->getMessage()]);
            return redirect()->route('visitas.edit', $id)->withErrors('Error al actualizar la visita.');
        }
    }
    


    public function create()
    {
        // Obtener datos de la base de datos
        $visitantes = Visitante::orderBy('documento_visitante')->get();
        $residentes = Residente::orderBy('apartamento')->get();
        $tipos = Tipopersona::all(); // Asegúrate de que el nombre del modelo es correcto
    
        return view('visitas.visitasadd', [
            'visitantes' => $visitantes,
            'residentes' => $residentes,
            'tipos' => $tipos,
        ]);
    }
    

    public function store(Request $request)
{
    date_default_timezone_set("America/Bogota");

    // Validar los datos
    $request->validate([
        'visitante_id' => 'required|exists:visitantes,id',
        'residente_id' => 'required|exists:residentes,id',
        'motivo_visita' => 'required|string|max:255',
        'vehiculo' => 'nullable|string|max:50',
    ]);

    // Crear una nueva visita
    $visita = new Visita();
    $visita->visitante_id = $request->visitante_id;
    $visita->residente_id = $request->residente_id;
    $visita->motivo_visita = $request->motivo_visita;
    $visita->vehiculo = $request->vehiculo;
    $visita->fecha_ingreso = now(); // Usar la fecha y hora actual
    $visita->save();

    return redirect()->route('visitas.index')->with('success', 'Visita registrada exitosamente.');
}


    public function destroy($id)
    {
        try {
            // Eliminar la visita de la base de datos
            $visita = Visita::findOrFail($id);
            $visita->delete();

            return redirect()->route('visitas.index')->with('success', 'Visita eliminada con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar la visita:', ['error' => $e->getMessage()]);
            return redirect()->route('visitas.index')->withErrors('Error al eliminar la visita.');
        }
    }
}