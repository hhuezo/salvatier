<?php

namespace App\Http\Controllers\administracion;

use App\Http\Controllers\Controller;
use App\Models\administracion\Notificacion;
use App\Models\Configuracion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

        // ===== Obtener la URL base de la API desde la base de datos =====
        $configuracion = Configuracion::first();

        if (!$configuracion || empty($configuracion->detalle)) {
            Log::error('❌ No se encontró la configuración de API backend en la base de datos.');
            return redirect()->back()->with('error', 'No se pudo obtener la configuración del servicio de correo.');
        }

        $baseUrl = rtrim($configuracion->detalle, '/');

        // ===== Envío de correo =====
        $emailDestino = $notificacion->asesoria->user->email ?? null;

        if ($emailDestino) {
            $asuntoEmail = 'Notificación sobre asesoría';
            $cuerpoEmail = $validated['mensaje'];

            // Generar la ruta completa solo si hay archivo
            $rutaCompletaArchivo = null;
            if ($notificacion->archivo) {
                $rutaCompletaArchivo = storage_path('app/public/notificaciones/' . $notificacion->archivo);
            }

            try {
                // Construir el cuerpo de la petición
                $payload = [
                    "to" => $emailDestino,
                    "subject" => $asuntoEmail,
                    "body" => $cuerpoEmail,
                    "attachments" => []
                ];

                // Adjuntar archivo si existe
                if ($rutaCompletaArchivo && file_exists($rutaCompletaArchivo)) {
                    $payload["attachments"][] = [
                        "base64File" => base64_encode(file_get_contents($rutaCompletaArchivo)),
                        "contentType" => mime_content_type($rutaCompletaArchivo),
                        "name" => basename($rutaCompletaArchivo)
                    ];
                }

                // Enviar petición HTTP a la API
                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->post($baseUrl . '/microsoft/send-mail', $payload);

                // Verificar la respuesta
                if ($response->successful()) {
                    Log::info("📨 Correo enviado correctamente vía API Microsoft.", [
                        'destinatario' => $emailDestino,
                        'asunto' => $asuntoEmail,
                    ]);
                } else {
                    Log::error("❌ Error al enviar correo vía API Microsoft.", [
                        'status' => $response->status(),
                        'respuesta' => $response->body(),
                        'destinatario' => $emailDestino,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error("⚠️ Excepción al enviar correo vía API: " . $e->getMessage());
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
