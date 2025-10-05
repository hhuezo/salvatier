<?php

namespace App\Http\Controllers\administracion;

use App\Http\Controllers\Controller;
use App\Models\administracion\EncargadoPago;
use Illuminate\Http\Request;

class EncargadoPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $encargado_pagos = EncargadoPago::get();
        return view('administracion.encargado_pago.index', compact('encargado_pagos'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validaciones
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|max:255',

        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser un texto válido.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.string' => 'El correo debe ser un texto válido.',
            'correo.max' => 'El correo no puede exceder 255 caracteres.',

        ]);

        // Guardar en la base de datos
        $encargado_pagos = new EncargadoPago();
        $encargado_pagos->nombre = $request->nombre;
        $encargado_pagos->correo = $request->correo;
        $encargado_pagos->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('encargado_pago.index')->with('success', 'Encargado pago registrada correctamente.');
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
        // Validaciones
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|max:255',

        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser un texto válido.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.string' => 'El correo debe ser un texto válido.',
            'correo.max' => 'El correo no puede exceder 255 caracteres.',

        ]);

        // Guardar en la base de datos
        $encargado_pagos = EncargadoPago::findOrFail($id);
        $encargado_pagos->nombre = $request->nombre;
        $encargado_pagos->correo = $request->correo;
        $encargado_pagos->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('encargado_pago.index')->with('success', 'Encargado pago modificada correctamente.');
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
