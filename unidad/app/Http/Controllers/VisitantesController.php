<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VisitantesController extends Controller
{
    
    public function index()
    {
        $url = 'https://apis.xn--oscarcaas-r6a.co/api/visitantes';

 
        $response = Http::get($url);

        if ($response->successful()) {
            $visitantes = $response->json();   
            return view('visitantes.index', ['visitantes' => $visitantes]);
        } else {
            // Manejar el error
            return view('api.error', ['message' => 'Error al consumir la API']);
        }
       
    }

    public function create()
    {
        
       $url = 'https://apis.xn--oscarcaas-r6a.co/api/tipos';
       
       $response = Http::get($url);
       
       if ($response->successful()) {        
        $tipos = $response->json();
       }

       

        return view('visitantes.visitanteadd', [
            'tipos' => $tipos
        ]);
    
    
    }

    public function store(Request $request)
    {
        //
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
