<?php

namespace App\Http\Controllers;

use App\Models\Residente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ResidentesController extends Controller
{
    public function index()
    {
        // Obtener todos los residentes de la base de datos
        $residentes = Residente::all();

        // Retornar la vista con los datos de los residentes
        return view('residentes.index', ['residentes' => $residentes]);
    }

    public function create()
    {
        // Retornar la vista de creación de residentes
        return view('residentes.residentesadd');
    }

    public function store(Request $request)
{
    // Validación de los datos del formulario
    $validatedData = $request->validate([
        'documento' => 'required|string|max:255',
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'edad' => 'required|integer',
        'correo' => 'nullable|email|max:255',
        'telefono' => 'nullable|string|max:10',
        'apartamento' => 'required|string|max:255',
        'mascota' => 'nullable|string|max:255',
        'condicion' => 'nullable|string|max:255',
        'discapacidad' => 'nullable|string|max:255',
    ]);

    try {
        // Crear un nuevo residente en la base de datos
        Residente::create($validatedData);

        // Redireccionar a la vista de index con un mensaje de éxito
        return redirect()->route('residentes.index')->with('success', 'Residente agregado con éxito.');
    } catch (\Exception $e) {
        Log::error('Error al agregar el residente:', ['error' => $e->getMessage()]);
        return redirect()->route('residentes.create')->withErrors('Error al agregar el residente.');
    }
}

    public function show(string $id)
    {
        // Obtener un residente específico
        $residente = Residente::findOrFail($id);

        // Retornar la vista con los detalles del residente
        return view('residentes.show', compact('residente'));
    }

    public function edit(string $id)
    {
        // Obtener el residente a editar
        $residente = Residente::findOrFail($id);

        // Retornar la vista de edición con los datos del residente
        return view('residentes.edit', compact('residente'));
    }

    public function update(Request $request, string $id)
    {
        // Validación de los datos del formulario
        $validatedData = $request->validate([
            'documento' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'edad' => 'required|integer',
            'correo' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:10',
            'apartamento' => 'required|string|max:255',
            'mascota' => 'nullable|string|max:255',
            'condicion' => 'nullable|string|max:255', 
            'discapacidad' => 'nullable|string|max:255',
        ]);

        try {
            // Actualizar el residente en la base de datos
            $residente = Residente::findOrFail($id);
            $residente->update($validatedData);

            // Redireccionar a la vista de index con un mensaje de éxito
            return redirect()->route('residentes.index')->with('success', 'Residente actualizado con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar el residente:', ['error' => $e->getMessage()]);
            return redirect()->route('residentes.edit', $id)->withErrors('Error al actualizar el residente.');
        }
    }

    public function destroy(string $id)
    {
        try {
            // Eliminar un residente de la base de datos
            $residente = Residente::findOrFail($id);
            $residente->delete();

            // Redireccionar a la vista de index con un mensaje de éxito
            return redirect()->route('residentes.index')->with('success', 'Residente eliminado con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar el residente:', ['error' => $e->getMessage()]);
            return redirect()->route('residentes.index')->withErrors('Error al eliminar el residente.');
        }
    }
}