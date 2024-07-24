<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DepartamentosController extends Controller
{

    public function index()
    {
        $url = 'https://ph.xn--oscarcaas-r6a.co/api/departamentos';

        // Realizar la solicitud GET
        $response = Http::get($url);

        // Verificar el estado de la respuesta
        if ($response->successful()) {
            // Obtener el cuerpo de la respuesta como un array
            $deptos = $response->json();

            // Retornar la vista con los datos
            return view('departamentos.index', ['deptos' => $deptos]);
        } else {
            // Manejar el error
            return view('api.error', ['message' => 'Error al consumir la API']);
        }
    }


    public function create()
    {
        return view('departamentos.departamentoadd');
    }

    
    public function store(Request $request)
{
    $request->validate([
        'nombre_dpto' => 'required|string|max:255',
        'lider_id' => 'required|integer',
    ]);

    $response = Http::post('https://ph.xn--oscarcaas-r6a.co/api/departamentosadd', [
        'nombre_dpto' => $request->input('nombre_dpto'),
        'lider_id' => $request->input('lider_id'),
    ]);

    if ($response->successful()) {
        return redirect()->route('departamentos.index')->with('success', 'Departamento agregado exitosamente.');
    } else {
        return redirect()->route('departamentos.create')->withErrors('Error al agregar el departamento.');
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
