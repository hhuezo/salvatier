<?php

namespace App\Http\Controllers\administracion;

use App\Http\Controllers\Controller;
use App\Models\administracion\Asesoria;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AsesoriaController extends Controller
{
    public function index()
    {
        $asesorias = Asesoria::with(['estado', 'modo', 'tipo', 'user'])->get();

        return view('administracion.asesoria.index', compact('asesorias'));
    }


    public function confirmar(Request $request)
    {
        try {
            $asesoria = Asesoria::findOrFail($request->id);
            $asesoria->estado_asesoria_id = 2;
            if ($request->enlace) {
                $asesoria->enlace = $request->enlace;
            }
            $asesoria->save();

            return back()->with('success', 'Asesoría confirmada correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al confirmar la asesoría: ' . $e->getMessage());
        }
    }

    public function reagendar(Request $request)
    {
        try {
            $asesoria = Asesoria::findOrFail($request->id);
            $asesoria->estado_asesoria_id = 3;
            $asesoria->fecha = $request->fecha;
            $asesoria->hora = $request->hora;
            $asesoria->save();

            return back()->with('success', 'Asesoría confirmada correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al confirmar la asesoría: ' . $e->getMessage());
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        $asesoria = Asesoria::with(['modo', 'estado', 'tipo', 'user'])->findOrFail($id);

        // Formatear fecha y hora
        $asesoria->fecha = $asesoria->fecha ? Carbon::parse($asesoria->fecha)->format('Y-m-d') : null;
        $asesoria->hora  = $asesoria->hora ? date('H:i', strtotime($asesoria->hora)) : null;

        return response()->json([
            'success' => true,
            'data' => $asesoria
        ]);
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
