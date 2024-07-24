<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VisitantesController extends Controller
{
    public function index()
    {


        // Realizar la solicitud GET
        $url = 'https://ph.xn--oscarcaas-r6a.co/api/visitantes';
        $response = Http::get($url);

        // Verificar el estado de la respuesta
        if ($response->successful()) {
            // Obtener el cuerpo de la respuesta como un array
            $visitantes = $response->json();

            // Retornar la vista con los datos
            return view('visitantes.index', ['visitantes' => $visitantes]);
        } else {
            // Manejar el error
            return view('api.error', ['message' => 'Error al consumir la API']);
        }
    }

    public function create()
    {
        $url = 'https://ph.xn--oscarcaas-r6a.co/api/tipos';
        $response = Http::get($url);

        if ($response->successful()) {
            $tipos = $response->json();
        } else {
            $tipos = []; // Fallback empty array in case of error
        }

        return view('visitantes.visitanteadd', [
            'tipos' => $tipos
        ]);
    }

    public function store(Request $request)
    {
        Log::info('Datos del formulario recibidos:', $request->all());
        $request->validate([
            'documento_visitante' => 'required|string|max:20',
            'nombre_visitante' => 'required|string|max:100',
            'apellido_visitante' => 'required|string|max:100',
            'id_tipo_visitante' => 'required|integer',
        ]);

        $response = Http::post('https://ph.xn--oscarcaas-r6a.co/api/visitantesadd', [
            'documento_visitante' => $request->input('documento_visitante'),
            'nombre_visitante' => $request->input('nombre_visitante'),
            'apellido_visitante' => $request->input('apellido_visitante'),
            'id_tipo_visitante' => $request->input('id_tipo_visitante'),
        ]);

        // Manejar la respuesta de la API
        if ($response->successful()) {
            return redirect()->route('visitantes.index')->with('success', 'Visitante agregado con éxito');
        } else {
            return redirect()->route('visitantes.create')->withErrors('Error al agregar al visitante');
        }
    }




    public function show(string $id)
    {
        // Code to show a specific visitante
    }

    public function edit(string $id)
    {
        // Code to show the edit form for a specific visitante
    }

    public function update(Request $request, string $id)
    {
        // Code to update a specific visitante
    }

    public function destroy(string $id)
    {
        // Code to delete a specific visitante
    }
}
