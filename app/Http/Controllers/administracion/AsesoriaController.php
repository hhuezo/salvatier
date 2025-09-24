<?php

namespace App\Http\Controllers\administracion;

use App\Http\Controllers\Controller;
use App\Models\administracion\Asesoria;
use App\Models\administracion\AsesoriaHistorial;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsesoriaController extends Controller
{
    public function index()
    {
        $asesorias = Asesoria::with(['estado', 'modo', 'tipo', 'user'])->get();
        $abogados = User::whereHas('roles', function ($q) {
            $q->where('id', 2);
        })->get();

        return view('administracion.asesoria.index', compact('asesorias', 'abogados'));
    }


    public function confirmar(Request $request)
    {
        $validated = $request->validate([
            'id'                  => 'required|exists:asesoria,id',
            'abogado_asignado_id' => 'nullable|exists:users,id',
            'enlace'              => 'nullable|string|max:500',
        ], [
            'id.required' => 'El ID de la asesoría es obligatorio.',
            'id.exists'   => 'La asesoría seleccionada no existe.',

            'abogado_asignado_id.exists' => 'El abogado seleccionado no es válido.',

            'enlace.string' => 'El enlace debe ser un texto válido.',
            'enlace.max'    => 'El enlace no puede superar los 500 caracteres.',
        ]);

        DB::beginTransaction();

        try {
            $asesoria = Asesoria::findOrFail($validated['id']);
            $asesoria->abogado_asignado_id = $validated['abogado_asignado_id'];
            $asesoria->estado_asesoria_id = 3; // confirmado
            if (!empty($validated['enlace'])) {
                $asesoria->enlace = $validated['enlace'];
            }
            $asesoria->save();

            $historial = new AsesoriaHistorial();
            $historial->descripcion        = $asesoria->descripcion;
            $historial->fecha              = $asesoria->fecha;
            $historial->hora               = $asesoria->hora;
            $historial->enlace             = $asesoria->enlace;
            $historial->asesoria_id        = $asesoria->id;
            $historial->estado_asesoria_id = $asesoria->estado_asesoria_id;
            $historial->tipo_asesoria_id   = $asesoria->tipo_asesoria_id;
            $historial->modo_asesoria_id   = $asesoria->modo_asesoria_id;
            $historial->user_id            = $asesoria->user_id;
            $historial->abogado_asignado_id  = $asesoria->abogado_asignado_id;
            $historial->save();

            DB::commit();

            return back()->with('success', 'Asesoría confirmada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al confirmar la asesoría: ' . $e->getMessage());
        }
    }

    public function reagendar(Request $request)
    {
        $validated = $request->validate([
            'id'    => 'required|exists:asesoria,id',
            'fecha' => 'required|date|after:today',
            'hora'  => 'required|date_format:H:i',
        ], [
            'id.required' => 'El ID de la asesoría es obligatorio.',
            'id.exists'   => 'La asesoría seleccionada no existe.',

            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date'     => 'La fecha debe tener un formato válido.',
            'fecha.after'    => 'La fecha debe ser mayor a la fecha actual.',

            'hora.required'    => 'La hora es obligatoria.',
            'hora.date_format' => 'La hora debe tener el formato HH:mm.',
        ]);

        DB::beginTransaction();

        try {
            $asesoria = Asesoria::findOrFail($validated['id']);
            $asesoria->estado_asesoria_id = 4; // reagendada
            $asesoria->fecha = $validated['fecha'];
            $asesoria->hora  = $validated['hora'];
            $asesoria->save();

            $historial = new AsesoriaHistorial();
            $historial->descripcion          = $asesoria->descripcion;
            $historial->fecha                = $asesoria->fecha;
            $historial->hora                 = $asesoria->hora;
            $historial->enlace               = $asesoria->enlace;
            $historial->asesoria_id          = $asesoria->id;
            $historial->estado_asesoria_id   = $asesoria->estado_asesoria_id;
            $historial->tipo_asesoria_id     = $asesoria->tipo_asesoria_id;
            $historial->modo_asesoria_id     = $asesoria->modo_asesoria_id;
            $historial->user_id              = $asesoria->user_id;
            $historial->abogado_asignado_id  = $asesoria->abogado_asignado_id;
            $historial->comentario  = $request->comentario;
            $historial->save();

            DB::commit();

            return back()->with('success', 'La asesoría fue reagendada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al reagendar la asesoría: ' . $e->getMessage());
        }
    }


    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        $asesoria = Asesoria::with(['modo', 'estado', 'tipo', 'user', 'abogado_asignado'])->findOrFail($id);

        // Formatear fecha y hora
        $asesoria->fecha = $asesoria->fecha ? Carbon::parse($asesoria->fecha)->format('Y-m-d') : null;
        $asesoria->hora  = $asesoria->hora ? date('H:i', strtotime($asesoria->hora)) : null;

        $abogados = User::whereHas('roles', function ($q) {
            $q->where('id', 2);
        })->get();

        return view('administracion.asesoria.detalle', compact('asesoria','abogados'));
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
