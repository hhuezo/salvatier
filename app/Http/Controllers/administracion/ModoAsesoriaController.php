<?php

namespace App\Http\Controllers\administracion;

use App\Http\Controllers\Controller;
use App\Models\administracion\ModoAsesoria;
use Illuminate\Http\Request;

class ModoAsesoriaController extends Controller
{
    public function index()
    {
        $modos = ModoAsesoria::get();
        return view('administracion.modo_asesoria.index', compact('modos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:modo_asesoria,nombre',
            'costo'  => 'required|numeric|min:0.01',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string'   => 'El nombre debe ser texto.',
            'nombre.max'      => 'El nombre no puede superar los 100 caracteres.',
            'nombre.unique'   => 'Ya existe un modo de asesoría con este nombre.',

            'costo.required'  => 'El costo es obligatorio.',
            'costo.numeric'   => 'El costo debe ser un número.',
            'costo.min'       => 'El costo debe ser mayor a $0.01',
        ]);

        try {
            $modoAsesoria = new ModoAsesoria();
            $modoAsesoria->nombre = $request->nombre;
            $modoAsesoria->costo  = $request->costo;
            $modoAsesoria->save();

            return redirect()->back()->with('success', 'Modo de asesoría creado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al guardar: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
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
        $request->validate([
            'nombre' => 'required|string|max:100|unique:modo_asesoria,nombre,' . $id,
            'costo'  => 'required|numeric|min:0.01',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string'   => 'El nombre debe ser texto.',
            'nombre.max'      => 'El nombre no puede superar los 100 caracteres.',
            'nombre.unique'   => 'Ya existe un modo de asesoría con este nombre.',

            'costo.required'  => 'El costo es obligatorio.',
            'costo.numeric'   => 'El costo debe ser un número.',
            'costo.min'       => 'El costo debe ser al menos 0.01.',
        ]);

        try {
            $modoAsesoria = ModoAsesoria::findOrFail($id);
            $modoAsesoria->nombre = $request->nombre;
            $modoAsesoria->costo  = $request->costo;
            $modoAsesoria->save();

            return redirect()->back()->with('success', 'Modo de asesoría actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $modo = ModoAsesoria::findOrFail($id);

            $modo->activo = $modo->activo == 1 ? 0 : 1;
            $modo->save();

            return response()->json([
                'success' => true,
                'message' => $modo->activo == 1 ? 'modo activado' : 'modo desactivado',
                'nuevo_estado' => $modo->activo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
