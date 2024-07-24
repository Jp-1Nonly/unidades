<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class PersonasController extends Controller
{
    
    public function index()
    {
        $url = 'https://ph.xn--oscarcaas-r6a.co/api/personas';

        // Realizar la solicitud GET
        $response = Http::get($url);

        // Verificar el estado de la respuesta
        if ($response->successful()) {
            // Obtener el cuerpo de la respuesta como un array
            $personas = $response->json();

            // Retornar la vista con los datos
            return view('personas.index', ['personas' => $personas]);
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
       }

       $url = 'https://ph.xn--oscarcaas-r6a.co/api/cargos';
       
       $response = Http::get($url);
       
       if ($response->successful()) {        
        $cargos = $response->json();
       }

       $url = 'https://ph.xn--oscarcaas-r6a.co/api/departamentos';

        // Realizar la solicitud GET
        $response = Http::get($url);

        // Verificar el estado de la respuesta
        if ($response->successful()) {
            // Obtener el cuerpo de la respuesta como un array
            $dptos = $response->json();
        }

        return view('personas.personasadd', [
            'tipos' => $tipos,
            'cargos' => $cargos,
            'dptos' => $dptos
        ]);
    
    }

    public function store(Request $request)
    {
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
    
        $response = Http::post('https://ph.xn--oscarcaas-r6a.co/api/personasadd', [
            'documento' => $request->input('documento'),
            'nombre_persona' => $request->input('nombre_persona'),
            'apellido' => $request->input('apellido'),
            'correo' => $request->input('correo'),
            'telefono' => $request->input('telefono'),
            'fecha_contratacion' => $request->input('fecha_contratacion'),
            'cargo_id' => $request->input('cargo_id'),
            'departamento_id' => $request->input('departamento_id'),
        ]);
    
        if ($response->successful()) {
            return redirect()->route('personas.index')->with('success', 'Persona agregada exitosamente.');
        } else {
            return redirect()->route('personas.create')->withErrors('Error al agregar la persona.');
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
