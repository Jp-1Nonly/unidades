<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VisitasController extends Controller
{
    public function index()
    {
        $url = 'https://ph.xn--oscarcaas-r6a.co/api/visitas';

        // Realizar la solicitud GET
        $response = Http::get($url);

        // Verificar el estado de la respuesta
        if ($response->successful()) {
            // Obtener el cuerpo de la respuesta como un array
            $visitas = $response->json();

            // Retornar la vista con los datos
            return view('visitas.index', ['visitas' => $visitas]);
        } else {
            // Manejar el error
            return view('api.error', ['message' => 'Error al consumir la API']);
        }
    }

    public function create()
    {
        // Fetch visitantes data
        $visitantes = $this->fetchData('https://ph.xn--oscarcaas-r6a.co/api/visitantes');

        $visitantes = $this->sortByDocumento($visitantes);

        // Fetch residentes data
        $residentes = $this->fetchData('https://ph.xn--oscarcaas-r6a.co/api/residentes');

        // Ordenar residentes por apartamento
        $residentes = $this->sortByApartamento($residentes);

        return view('visitas.visitasadd', [
            'visitantes' => $visitantes,
            'residentes' => $residentes,
        ]);
    }

    
    private function fetchData($url)
    {
        $response = Http::get($url);

        if ($response->successful()) {
            return $response->json();
        } else {
           
            Log::error('Failed to fetch data from ' . $url, ['status' => $response->status()]);
            return []; 
        }
    }

    private function sortByApartamento(array $residentes)
    {
        usort($residentes, function($a, $b) {
            return strcmp($a['apartamento'], $b['apartamento']);
        });

        return $residentes;
    }

    private function sortByDocumento(array $visitantes)
    {
        usort($visitantes, function($a, $b) {
            return strcmp($a['documento_visitante'], $b['documento_visitante']);
        });

        return $visitantes;
    }

    public function store(Request $request)
{
    Log::info('Datos del formulario recibidos:', $request->all());

    $validatedData = $request->validate([
        'visitante_id' => 'required|integer',
        'residente_id' => 'required|integer',
        'fecha_ingreso' => 'nullable|date',
        'motivo_visita' => 'required|string|max:255',
        'vehiculo' => 'nullable|string|max:10',
    ]);


    Log::info('Datos validados con fecha:', $validatedData);

    $response = Http::post('https://ph.xn--oscarcaas-r6a.co/api/visitasadd', $validatedData);

    Log::info('Respuesta de la API:', [
        'status' => $response->status(),
        'body' => $response->body()
    ]);

    if ($response->successful()) {
        return redirect()->route('visitas.index')->with('success', 'Visita agregada con éxito.');
    } else {
        $error = $response->json('error', 'Error desconocido');
        $errorMessage = $response->json('message', 'Error desconocido');
        return redirect()->route('visitas.create')->withErrors('Error al agregar la visita ' . $error . ' - ' . $errorMessage);
    }
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
