<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ResidentesController extends Controller
{
    public function index()
    {
        // Realizar la solicitud GET
        $url = 'https://ph.xn--oscarcaas-r6a.co/api/residentes';
        $response = Http::get($url);

        // Verificar el estado de la respuesta
        if ($response->successful()) {
            // Obtener el cuerpo de la respuesta como un array
            $residentes = $response->json();

            // Retornar la vista con los datos
            return view('residentes.index', ['residentes' => $residentes]);
        } else {
            // Manejar el error
            return view('api.error', ['message' => 'Error al consumir la API']);
        }
    }
    

    
    public function create()
    {
        return view('residentes.residentesadd', [
            
        ]);
    }

    
    public function store(Request $request)
{
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
        $response = Http::post('https://ph.xn--oscarcaas-r6a.co/api/residentesadd', $validatedData);

        Log::info('Respuesta de la API:', ['response' => $response->json()]);

        if ($response->successful()) {
            return redirect()->route('residentes.index')->with('success', 'Residente agregado con éxito.');
        } else {
            return redirect()->route('residentes.create')->withErrors('Error al agregar el residente: ' . $response->json('error'));
        }
    } catch (\Exception $e) {
        Log::error('Error al realizar la solicitud a la API:', ['error' => $e->getMessage()]);
        return redirect()->route('residentes.create')->withErrors('Error al realizar la solicitud a la API.');
    }
}


    
    public function show(string $id)
    {
        //
    }

    
    public function edit(string $id)
    {
        //
    }

    
    public function update(Request $request, string $id)
    {
        //
    }

    
    public function destroy(string $id)
    {
        //
    }
}
