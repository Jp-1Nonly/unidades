<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DepartamentosController extends Controller
{
    public function index()
    {
        // Obtener todos los departamentos de la base de datos
        $deptos = Departamento::all();

        // Retornar la vista con los datos de los departamentos
        return view('departamentos.index', ['deptos' => $deptos]);
    }

    public function create()
    {
        // Retornar la vista de creación de departamentos
        return view('departamentos.departamentoadd');
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'nombre_dpto' => 'required|string|max:255',
            'lider_id' => 'required|integer',
        ]);

        // Crear un nuevo departamento en la base de datos
        Departamento::create([
            'nombre_dpto' => $request->input('nombre_dpto'),
            'lider_id' => $request->input('lider_id'),
        ]);

        // Redireccionar a la vista de index con un mensaje de éxito
        return redirect()->route('departamentos.index')->with('success', 'Departamento agregado exitosamente.');
    }

    public function show(string $id)
    {
        // Obtener un departamento específico
        $departamento = Departamento::findOrFail($id);

        // Retornar la vista con los detalles del departamento
        return view('departamentos.show', compact('departamento'));
    }

    public function edit(string $id)
    {
        // Obtener el departamento a editar
        $departamento = Departamento::findOrFail($id);

        // Retornar la vista de edición con los datos del departamento
        return view('departamentos.edit', compact('departamento'));
    }

    public function update(Request $request, string $id)
    {
        // Validación de los datos del formulario
        $request->validate([
            'nombre_dpto' => 'required|string|max:255',
            'lider_id' => 'required|integer',
        ]);

        // Actualizar el departamento en la base de datos
        $departamento = Departamento::findOrFail($id);
        $departamento->update([
            'nombre_dpto' => $request->input('nombre_dpto'),
            'lider_id' => $request->input('lider_id'),
        ]);

        // Redireccionar a la vista de index con un mensaje de éxito
        return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        // Eliminar un departamento de la base de datos
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();

        // Redireccionar a la vista de index con un mensaje de éxito
        return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado exitosamente.');
    }
}