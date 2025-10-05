<?php

namespace App\Http\Controllers\administracion;

use App\Http\Controllers\Controller;
use App\Models\administracion\Notificacion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificacionController extends Controller
{
    public function index()
    {
        // Obtener todas las notificaciones con la información del usuario
        $notificaciones = Notificacion::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('administracion.notificacion.index', compact('notificaciones'));
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
        $validated = $request->validate([
            'asesoria_id' => 'required|exists:asesoria,id',
            'mensaje' => 'required|string|max:500',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:2048',
        ], [
            'asesoria_id.required' => 'Debe seleccionar una asesoría válida.',
            'asesoria_id.exists' => 'La asesoría seleccionada no existe en el sistema.',
            'mensaje.required' => 'El campo mensaje es obligatorio.',
            'mensaje.max' => 'El mensaje no puede superar los 500 caracteres.',
            'archivo.file' => 'El archivo debe ser un archivo válido.',
            'archivo.mimes' => 'El archivo debe ser un PDF, DOC, DOCX, JPG, JPEG o PNG.',
            'archivo.max' => 'El archivo no puede superar los 2MB de tamaño.',
        ]);

        $archivoNombre = null;
        $rutaCompletaArchivo = null;

        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $archivoNombre = time() . '_' . $archivo->getClientOriginalName();
            // Guardar directamente en storage/app/public/notificaciones
            $archivo->storeAs('public/notificaciones', $archivoNombre);

            // Construir la ruta completa para adjuntar al correo
            $rutaCompletaArchivo = storage_path('app/public/notificaciones/' . $archivoNombre);
        }

        $notificacion = new Notificacion();
        $notificacion->asesoria_id = $validated['asesoria_id'];
        $notificacion->user_id = auth()->id();
        $notificacion->mensaje = $validated['mensaje'];
        $notificacion->fecha = now();
        $notificacion->archivo = $archivoNombre;
        $notificacion->leido = false;
        $notificacion->save();



        $emailDestino = $notificacion->asesoria->user->email ?? null;

        if ($emailDestino) {
            $asuntoEmail = 'Notificacion sobre asesoria';
            $cuerpoEmail = $validated['mensaje'];

            // Generar la ruta completa solo si hay archivo
            $rutaCompletaArchivo = null;
            if ($notificacion->archivo) {
                $rutaCompletaArchivo = storage_path('app/public/notificaciones/' . $notificacion->archivo);
            }

            try {
                Mail::raw($cuerpoEmail, function ($message) use ($emailDestino, $asuntoEmail, $rutaCompletaArchivo) {
                    $message->to($emailDestino)
                        ->subject($asuntoEmail);

                    if ($rutaCompletaArchivo && file_exists($rutaCompletaArchivo)) {
                        $message->attach($rutaCompletaArchivo);
                    }
                });
            } catch (Exception $e) {
                Log::error("Fallo al enviar el correo de notificación: " . $e->getMessage());
            }
        } else {
            Log::warning("No se envió correo: la asesoría no tiene un usuario con email válido.");
        }



        return redirect()
            ->back()
            ->with('success', 'La notificación fue enviada correctamente.');
    }



    public function show(string $id)
    {
        try {
            $notificacion = Notificacion::with('user')->findOrFail($id);

            return view('administracion.notificacion.detalle', compact('notificacion'));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo obtener la notificación: ' . $e->getMessage()
            ], 500);
        }
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
