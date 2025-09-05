<?php

namespace App\Http\Controllers\usuario;

use App\Http\Controllers\Controller;
use App\Models\administracion\Asesoria;
use App\Models\administracion\ModoAsesoria;
use App\Models\administracion\TipoAsesoria;
use Illuminate\Http\Request;

class AsesoriaUsuarioController extends Controller
{

    public function index()
    {
        $asesorias = Asesoria::with(['estado', 'modo', 'tipo', 'user'])->where('user_id', auth()->user()->id)->get();
        $tipos = TipoAsesoria::get();
        $modos = ModoAsesoria::get();

        return view('usuario.asesoria.index', compact('asesorias', 'tipos', 'modos'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha'             => 'required|date|after:today',
            'hora'              => 'required|date_format:H:i',
            'tipo_asesoria_id'  => 'required|exists:tipo_asesoria,id',
            'modo_asesoria_id'  => 'required|exists:modo_asesoria,id',
            'descripcion'       => 'nullable|string|max:1000',
        ], [
            'fecha.required'    => 'La fecha es obligatoria.',
            'fecha.date'        => 'La fecha debe tener un formato válido.',
            'fecha.after'       => 'La fecha debe ser mayor a la fecha actual.',

            'hora.required'     => 'La hora es obligatoria.',
            'hora.date_format'  => 'La hora debe tener el formato HH:mm.',

            'tipo_asesoria_id.required' => 'Debe seleccionar un tipo de asesoría.',
            'tipo_asesoria_id.exists'   => 'El tipo de asesoría seleccionado no es válido.',

            'modo_asesoria_id.required' => 'Debe seleccionar un modo de asesoría.',
            'modo_asesoria_id.exists'   => 'El modo de asesoría seleccionado no es válido.',

            'descripcion.string' => 'La descripción debe ser texto válido.',
            'descripcion.max'    => 'La descripción no puede superar los 1000 caracteres.',
        ]);

        try {
            $asesoria = new Asesoria();
            $asesoria->descripcion       = $validated['descripcion'] ?? null;
            $asesoria->fecha             = $validated['fecha'];
            $asesoria->hora              = $validated['hora'];
            $asesoria->tipo_asesoria_id  = $validated['tipo_asesoria_id'];
            $asesoria->modo_asesoria_id  = $validated['modo_asesoria_id'];
            $asesoria->estado_asesoria_id  = 1;
            $asesoria->user_id           = auth()->id();
            $asesoria->save();

            return redirect()->back()->with('success', 'La asesoría ha sido programada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error al registrar la asesoría: ' . $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function proximas()
    {
        $asesorias = Asesoria::with(['estado', 'modo', 'tipo', 'user'])
            ->where('user_id', auth()->user()->id)
            ->get();

        $data = $asesorias->map(function ($asesoria) {
            return [
                "id"       => $asesoria->id,
                "title"       => "Asesoria",
                "start"       => $asesoria->fecha . ' ' . $asesoria->hora,
                "description" => "Modo: {$asesoria->modo->nombre}, Tipo: {$asesoria->tipo->nombre}",
                "backgroundColor" => "#6da595ff", // fondo azul
                "borderColor"     => "#036554", // borde azul
                "textColor"       => "#ffffff"  // texto blanco
            ];
        })->toArray();


        return view('usuario.asesoria.proximas', compact('data'));
    }

    public function sucursales()
    {
        return view('usuario.sucursales');
    }

    public function destroy(string $id)
    {
        //
    }
}
