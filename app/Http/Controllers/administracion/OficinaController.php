<?php

namespace App\Http\Controllers\administracion;

use App\Http\Controllers\Controller;
use App\Models\administracion\Oficina;
use Illuminate\Http\Request;

class OficinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $oficina = Oficina::get();
        return view('administracion.oficina.index', compact('oficina'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validaciones
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'ubicacion' => 'nullable|string|max:150',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'direccion.required' => 'La dirección es obligatoria.',
        ]);

        // Guardar en la base de datos
        $oficina = new Oficina();
        $oficina->nombre = $request->nombre;
        $oficina->direccion = $request->direccion;
        $oficina->telefono = $request->telefono;
        $oficina->ubicacion = $request->ubicacion;
        $oficina->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('oficina.index')->with('success', 'Oficina registrada correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validaciones
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'ubicacion' => 'nullable|string|max:150',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'direccion.required' => 'La dirección es obligatoria.',
        ]);

        // Actualizar registro
        $oficina = Oficina::findOrFail($id);
        $oficina->nombre = $request->nombre;
        $oficina->direccion = $request->direccion;
        $oficina->telefono = $request->telefono;
        $oficina->ubicacion = $request->ubicacion;
        $oficina->save();

        return redirect()->route('oficina.index')->with('success', 'Oficina modificada correctamente.');
    }
}
